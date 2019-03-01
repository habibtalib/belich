<script>
    /*
    Section: Form
    Description: Count textArea Characters.
    */
    function textAreaCount(container, id) {
        document.getElementById('chars-' + id).innerHTML = "Characters left: " + (this.maxlength - this.value.length);
    }
</script>
