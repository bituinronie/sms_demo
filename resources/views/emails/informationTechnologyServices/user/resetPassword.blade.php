<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter"
      rel="stylesheet"
    />
    <style>
      * {
        font-family: "Inter";
      }
      body {
        background-color: rgb(227, 228, 255);
        justify-content: center;
        padding: 50px 5%;
      }
      a {
        text-decoration: none; 
        color: #3f51b5; 
        font-weight: bold;
      }
      .title {
        font-size: 30px;
      }
      .text-center {
        text-align: center;
      }
      .sheet {
        background-color: white;
        margin: 50px auto;
        padding: 80px 10%;
        border-radius: 10px;
        text-align: center;
        max-width: 300px;

      }
      .pill {
        border: 2px solid #3F51B5;
        border-radius: 10px;
        padding: 10px;
        margin: 10px auto;
        max-width: 250px;
        word-wrap: break-word
      }
      .image {
        transition: opacity .4s cubic-bezier(.4,0,.2,1);
        background-size: cover;
        background-position: center center;
        max-width: 150px;
        margin-bottom: 50px;
      }
      footer div {
        margin-top: 3px
      }
      @media (max-width: 350px) {
        .title {
          font-size: 25px;
        }
      }
    </style>
  </head>
  <body>

    <div class="text-center">
      <div class="title">Hi <span style="text-transform: capitalize;"><strong>{{$mailData['name']}}!</strong></span></div>
      <div style="padding: 10px">Your account has been reset</div>
    </div>

    <div class="sheet">

      <img src="data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIKCSB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8cGF0aCBzdHlsZT0iZmlsbDojMUUwNDc4OyIgZD0iTTUxMC41NjksMjY0LjUzM2MwLjk2MiwyLjYxMSwxLjQzMiw1LjI5MSwxLjQzMiw3LjkyNmMwLDkuMzExLTUuNzI3LDE4LjA4NC0xNC45NjksMjEuNTA5CglMMjEyLjEyNCwzOTkuMzdjLTIuNTg4LDAuOTYyLTUuMjgsMS40MzItNy45NiwxLjQzMmMtMy4yNjQsMC02LjUxNy0wLjY5OS05LjU2My0yLjEwN2MtNS41NTUtMi41NTQtOS43OTItNy4xMjQtMTEuOTExLTEyLjg2MgoJbC01OC40MzQtMTU3LjkzOGMtMi4xMTktNS43MzgtMS44NzgtMTEuOTU3LDAuNjc2LTE3LjUxMmMyLjU1NC01LjU2Niw3LjEyNC05Ljc5MiwxMi44NjItMTEuOTIzTDQyMi43MTIsOTMuMDU3CgljNS43MzgtMi4xMTksMTEuOTU3LTEuODc4LDE3LjUxMiwwLjY3NmM1LjU2NiwyLjU1NCw5Ljc5Miw3LjEyNCwxMS45MTEsMTIuODYyTDUxMC41NjksMjY0LjUzM3ogTTQ4NC45NzEsMjYxLjMyNmwtNTAuNzAzLTEzNy4wMTMKCWwtNjkuNDYzLDk5LjMyMUw0ODQuOTcxLDI2MS4zMjZ6IE0yMjQuODYsMzcwLjIzM2wyNDMuNTM5LTkwLjEwMWwtMTE3LjM3MS0zNi44MWwtMTguMTMsMjUuOTQxYy0yLjE3NiwzLjEwNC01LjcwNCw0Ljg5LTkuMzkyLDQuODkKCWMtMC45MzksMC0xLjkwMS0wLjEyNi0yLjg1Mi0wLjM2NmwtMzAuNjM3LTcuODhMMjI0Ljg2LDM3MC4yMzN6IE0zMTguNjcyLDI0OS42MjFsODguMzcyLTEyNi4zMzlsLTIzNy42OTcsODcuOTM3TDMxOC42NzIsMjQ5LjYyMXoKCSBNMjAwLjA0MSwzNjYuNzI4bDY2LjcwMy0xMDYuODExbC0xMTcuMzgzLTMwLjE5TDIwMC4wNDEsMzY2LjcyOHoiLz4KPGc+Cgk8cG9seWdvbiBzdHlsZT0iZmlsbDojNkY3Q0NEOyIgcG9pbnRzPSI0MzQuMjY4LDEyNC4zMTIgNDg0Ljk3MSwyNjEuMzI2IDM2NC44MDUsMjIzLjYzNCAJIi8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojNkY3Q0NEOyIgZD0iTTQ2OC4zOTksMjgwLjEzMkwyMjQuODYsMzcwLjIzM2w2NS4xNTctMTA0LjMyNmwzMC42MzcsNy44OGMwLjk1MSwwLjI0MSwxLjkxMywwLjM2NywyLjg1MiwwLjM2NwoJCWMzLjY4OCwwLDcuMjE1LTEuNzg3LDkuMzkyLTQuODlsMTguMTMtMjUuOTQxTDQ2OC4zOTksMjgwLjEzMnoiLz4KPC9nPgo8cG9seWdvbiBzdHlsZT0iZmlsbDojOUI4Q0NDOyIgcG9pbnRzPSI0MDcuMDQ0LDEyMy4yODIgMzE4LjY3MiwyNDkuNjIxIDE2OS4zNDcsMjExLjIxOCAiLz4KPHBvbHlnb24gc3R5bGU9ImZpbGw6IzZGN0NDRDsiIHBvaW50cz0iMjY2Ljc0NCwyNTkuOTE3IDIwMC4wNDEsMzY2LjcyOCAxNDkuMzYxLDIyOS43MjcgIi8+CjxnPgoJPHBhdGggc3R5bGU9ImZpbGw6IzFFMDQ3ODsiIGQ9Ik0xMzMuNDQxLDM4OC45N2MyLjE5OSw1LjkzMy0wLjgzNiwxMi41MTgtNi43NjksMTQuNzE3bC00My4xNTUsMTUuOTY2CgkJYy0xLjMxNywwLjQ4MS0yLjY1NywwLjcyMi0zLjk3NCwwLjcyMmMtNC42NjEsMC05LjAzNi0yLjg2My0xMC43NDMtNy40OWMtMi4xOTktNS45MzMsMC44MzYtMTIuNTE4LDYuNzY5LTE0LjcxN2w0My4xNTUtMTUuOTY2CgkJQzEyNC42NTcsMzgwLjAxNCwxMzEuMjQyLDM4My4wMzgsMTMzLjQ0MSwzODguOTd6Ii8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojMUUwNDc4OyIgZD0iTTc1LjAxOSwyODIuNjRjMi4xOTksNS45MzMtMC44MzYsMTIuNTMtNi43NTcsMTQuNzE3bC0yNi42NTEsOS44NjEKCQljLTEuMzA2LDAuNDgxLTIuNjQ2LDAuNzEtMy45NzQsMC43MWMtNC42NSwwLTkuMDI1LTIuODUyLTEwLjc0My03LjQ3OWMtMi4xODgtNS45MzMsMC44MzYtMTIuNTE4LDYuNzY5LTE0LjcxN2wyNi42NTEtOS44NjEKCQlDNjYuMjM1LDI3My42ODQsNzIuODMyLDI3Ni43MDcsNzUuMDE5LDI4Mi42NHoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiMxRTA0Nzg7IiBkPSJNNDIsMzY5LjQwOGMyLjE4OCw1LjkzMy0wLjgzNiwxMi41MTgtNi43NjksMTQuNzA2bC0xOS44MDIsNy4zMwoJCWMtMS4zMDYsMC40ODEtMi42NDYsMC43MS0zLjk3NCwwLjcxYy00LjY1LDAtOS4wMjUtMi44NTItMTAuNzQzLTcuNDc5Yy0yLjE4OC01LjkzMywwLjgzNi0xMi41MTgsNi43NjktMTQuNzE3bDE5LjgwMi03LjMxOQoJCUMzMy4yMTUsMzYwLjQ0MSwzOS44MDEsMzYzLjQ3Niw0MiwzNjkuNDA4eiIvPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" alt="" class="image">

      <div>Here are your accounts credentials:</div>

      <div style="margin-top: 30px"><strong>ID</strong></div>
      <div class="pill">{{$mailData['id']}}</div>

      <div style="margin-top: 20px"><strong>PASSWORD</strong></div>
      <div class="pill">{{$mailData['password']}}</div>

      <div style="margin-top: 50px">
        This account has been reset, You can now log in to SPCF Portal.
      </div>

      <div style="margin-top: 50px">
        <a href="https://ictdevsms.azurewebsites.net/portal">Go to SPCF Portal</a>
      </div>
    </div>
      
  </body>
  <footer class="text-center" >
    <div style="font-size: 14px;">
      <div>Contact Us</div>
      <div><strong>Systems Plus College Foundation</strong></div>
      <div>0922-832-7082 | 09190692914</div>
      <div>(045) 322-7723</div>
      <div>info@spcf.edu.ph</div>
    </div>
    <div style="font-size: 10px; margin-top: 50px">Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
  </footer>
</html>
