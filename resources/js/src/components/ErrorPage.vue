<template>
    <div class="outer">
        <div class="middle">
            <div class="inner">
                <div class="error-status">{{ errorStatus }}</div>
                <div class="error-description">{{ errorDescription.toLowerCase() }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['errorStatus', 'errorDescription']
}
</script>

<style>
    .outer {
        display: table;
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
    }

    .middle {
        display: table-cell;
        vertical-align: middle;
    }

    .inner {
        margin-left: auto;
        margin-right: auto;
        width: 400px;
        text-align: center;
        /* Whatever width you want */
    }

    .error-status {
        font-size: 100px;
        font-weight: bold;
        letter-spacing: 5px;
    }

    .error-description {
        font-size: 20px;
    }

</style>