<div
    id="drop_zone"
    ondrop="dropHandler(event);"
    ondragover="dragOverHandler(event);"
    ondragleave="dragLeave(event);">
    <p id="drop_zone_text">Drag one or more files.</p>
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
</style>

<script>
    var filesToUpload = Array();
    function dropHandler(ev) {
        document.getElementById("drop_zone").classList.remove("dropOver");
        document.getElementById("drop_zone").classList.add("dropped");
        document.getElementById("drop_zone_text").innerHTML = "<a href='javascript:upload();'>Start uploading</a>";

        ev.preventDefault();

        if (ev.dataTransfer.items) {
            [...ev.dataTransfer.items].forEach((item, i) => {
            if (item.kind === "file") {
                const file = item.getAsFile();
                //console.log(`… file[${i}].name = ${file.name}`);
                filesToUpload.push(file);
            }
            });
        } else {
            [...ev.dataTransfer.files].forEach((file, i) => {
                //console.log(`… file[${i}].name = ${file.name}`);
                filesToUpload.push(file);
            });
        }
    }
    function dragOverHandler(ev) {
        document.getElementById("drop_zone").classList.add("dropOver");
        ev.preventDefault();
    }
    function dragLeave(ev) {
        document.getElementById("drop_zone").classList.remove("dropOver");
        ev.preventDefault();
    }
    function upload() {
        console.log(filesToUpload);
    }
</script>