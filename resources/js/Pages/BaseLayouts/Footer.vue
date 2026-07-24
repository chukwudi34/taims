<template>
    <div>
        <div class="footer_part">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer_iner text-center">
                            <p>{{devYear}} © Adewale,Kayode Abayomi,Tasued.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            devYear: ''
        }
    },
    mounted() {
        const d = new Date()
        this.devYear = d.getFullYear();
    }
}
</script>
