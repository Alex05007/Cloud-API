<div
    id="drop_zone"
    ondrop="dropHandler(event);"
    ondragover="dragOverHandler(event);"
    ondragleave="dragLeave(event);"
    onclick="fileExplore();">
    <p id="drop_zone_text">Drop your files here or select them.</p>
    <form id="form" enctype="multipart/form-data">
        <input type="file" id="file" name="filesToUpload[]" onchange="selectDone()">
    </form>
</div>

<style>
    #drop_zone {
        border: 3px #CCC dotted;
        border-radius: 10px;
        padding: 20px;
        transition: all 0.2s;

        width: 50vw;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .dropOver {
        border-style: solid !important;
    }
    .dropped {
        border: 3px #06d6a0 dotted !important;
        text-align: center;
    }
    #drop_zone a {
        background-color: #06d6a0;
        padding: 10px;
        border-radius: 5px;
        margin: auto;
        color: #FFF;
        text-decoration: none;
    }
    #file {
        display: none;
    }
.loading-anim {
        padding: 10px;
        border-radius: 5px;
        position: relative;
        transform: translate(-15px, -15px);
}
.loading-anim svg {
	width: 30px;
	height: 30px;
    fill: #06d6a0;
}
@keyframes rotation {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(359deg);
  }
}
#loading1 {
	animation: rotation 0.8s ease-out infinite;
    position: absolute;
    left: 50%;
}
#loading2 {
	animation: rotation 0.8s ease-in-out infinite;
    position: absolute;
    left: 50%;
}
</style>

<script src="https://gnets.myds.me/developer/cloud/jquery.js"></script>

<script>
    function dropHandler(ev) {
        document.getElementById("drop_zone").classList.remove("dropOver");
        document.getElementById("drop_zone").classList.add("dropped");
        document.getElementById("drop_zone_text").innerHTML = "<a href='javascript:upload();'>Start uploading</a>";

        ev.preventDefault();

        const dataTransfer = new DataTransfer();

        if (ev.dataTransfer.items) {
            [...ev.dataTransfer.items].forEach((item, i) => {
            if (item.kind === "file") {
                dataTransfer.items.add(item.getAsFile());
            }
            });
        } else {
            [...ev.dataTransfer.files].forEach((file, i) => {
                dataTransfer.items.add(item.getAsFile());
            });
        }
        document.getElementById('file').files = dataTransfer.files;
    }
    function selectDone() {
        upload();
    }
    function dragOverHandler(ev) {
        document.getElementById("drop_zone").classList.add("dropOver");
        ev.preventDefault();
    }
    function dragLeave(ev) {
        document.getElementById("drop_zone").classList.remove("dropOver");
        ev.preventDefault();
    }
    function fileExplore() {
        if (document.getElementById('file').files.length == 0)
            document.getElementById("file").click();
    }
    function upload() {
        document.getElementById("drop_zone").classList.remove("dropOver");
        document.getElementById("drop_zone_text").innerHTML = '<div class="loading-anim"><svg id="loading1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z"/></svg><svg id="loading2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z"/></svg></div>';

        var formData = new FormData(document.getElementById("form"));
        $.ajax({
            url: "upload.php",
            type: 'POST',
            data: formData,
            success: function (data) {
                console.log(data);
                if (data == "upload_done")
                    removeLoading();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    function removeLoading() {
        document.getElementById("drop_zone").classList.remove("dropped");
        document.getElementById("drop_zone_text").innerHTML = 'Drop your files here or select them.';
    }
</script>