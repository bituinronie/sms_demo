<template>
   <div>
       <ErrorPage :errorStatus="404" :errorDescription="'page not found'" />
   </div>
</template>

<script>
import ErrorPage from '../components/ErrorPage'
export default {
    components: {
        ErrorPage
    }
}
</script>