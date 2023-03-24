<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Food Post</title>
    <?php include_once 'header.php'; ?>
</head>
<body>
    <!-- Admin Page Wrapper -->
    <div class="admin-wrapper">
        <!-- Admin Content -->
        <div class="admin-content">
            <div class="content">
                <h2 class="page-title">Manage Posts</h2>
                <section class="blog-form">
                    <form id="add-post-form" method="POST">
                        <div>
                            <label>Title</label>
                            <input type="text" name="title" id="AjaxTitle" class="text-input">
                        </div>
                        <div>
                            <label>Body</label>
                            <textarea name="body" id="body"></textarea>
                        </div>
                    <!--
                        <div>
                        <label>Image</label>
                        <input type="file" name="image" class="text-input">
                    </div>
                    <div>
                        <label>Topic</label>
                        <select name="topic" class="text-input">
                            <option value="Poetry">Poetry</option>
                            <option value="Life Lessons">Life Lessons</option>
                        </select>
                    </div>
                    -->
                    <div>
                            <button type="submit" id="ajaxButton" class="btn btn-big">Add Post</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
        <!-- // Admin Content -->
    </div>
    <!-- // Page Wrapper -->
    <?php include_once 'footer.php'; ?>
    <script>
        document.getElementById("ajaxButton").addEventListener('click', function() {
            const title = document.getElementById("AjaxTitle").value;
            const bodytext = document.getElementById("body").value;
           // const topic = document.getElementsByName("topic")[0].value;
            //const image = document.getElementsByName("image")[0].files[0];
            SendPostRequest(title, bodytext,topic,image);
        });

       // function SendPostRequest(title, body, topic, image) {
        function SendPostRequest(title, body) {
            const xhr = new XMLHttpRequest();
            const formData = new FormData();
            formData.append('title', title);
            formData.append('body', body);
           // formData.append('topic', topic);
          //  formData.append('image', image);
            xhr.open('POST', 'add_post.php', true);
            xhr.send(formData);
        }
    </script>
</body>
</html>
