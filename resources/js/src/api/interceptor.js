import axios from "axios";
import { auth } from "../utils/auth"
import store from "../store"

export default function requestInterceptor(axiosInstance, router) {
    let isRefreshing = false;
    let failedQueue = [];

    const processQueue = (error, token = null) => {
        failedQueue.forEach(prom => {
            console.log(error)
            console.log(token)
            if (error) {
                prom.reject(error);
            } else {
                prom.resolve(token);
            }
        });

        failedQueue = [];
    };

    axiosInstance.interceptors.response.use(
        response => {
            return response;
        },
        err => {
            const originalRequest = err.config;
            if (err.response.status === 401 && !originalRequest._retry) {
                if (isRefreshing) {
                    return new Promise(function(resolve, reject) {
                        failedQueue.push({
                            resolve,
                            reject
                        });
                    })
                        .then(token => {
                            originalRequest.headers["Authorization"] =
                                "Bearer " + auth.token();
                            return axios(originalRequest);
                        })
                        .catch(err => {
                            return Promise.reject(err);
                        });
                }

                originalRequest._retry = true;
                isRefreshing = true;

                return new Promise(function(resolve, reject) {
                    const config = {
                        headers: {
                            Authorization: "Bearer " + auth.token()
                        }
                    };
                    const url = auth.isEmployee()
                        ? "user/accounts/refresh"
                        : auth.isStudent()
                        ? "student/portal/accounts/refresh"
                        : "";
                    axiosInstance
                        .post(url, {}, config)
                        .then(({ data }) => {
                            let user = auth.auth();
                            user.access_token = data.access_token;
                            store.commit("user/SET_USER", user);
                            originalRequest.headers["Authorization"] = "Bearer " + data.access_token;
                            processQueue(null, data.access_token);
                            resolve(axios(originalRequest));
                        })
                        .catch(err => {
                            processQueue(err, null);
                            reject(err);
                            store.commit("user/DESTROY_USER");
                            router.push({name: 'Login'})
                        })
                        .finally(() => {
                            isRefreshing = false;
                        });
                });
            }

            return Promise.reject(err);
        }
    );
}
