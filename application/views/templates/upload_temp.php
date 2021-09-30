
<form method="post" enctype="multipart/form-data" action="<?=site_url('fileupload/cobaupload')?>">
    <input type="file" name="file" id="pdf" accept="application/pdf" required><br><p>


    <input type="submit" name="submit"  value='Upload' class='btn btn-primary' onclick="Upload()">
</form>

<script type="text/javascript">
    function Upload() {
        var fileUpload = document.getElementById("pdf");
        if (fileUpload.files && fileUpload.files[0].size > (100 * 1024)) {
            alert("File too large. Max 10 MB allowed.");
            fileUpload.value = null;
        }
    }
</script>