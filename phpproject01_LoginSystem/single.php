<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        <?php echo $_GET['title']; ?> - CompileCart
    </title>
    <?php include_once 'header.php'; ?>
    <style>
        .post {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: justify;
            text-justify: inter-word;
        }

        .post-image {
            margin-top: 20px;
            width: 100%;
            max-width: 720px;
            height: auto;
            width: 250px; /* set the width to a smaller value */
        }

        .post-title {
            font-size: 2em;
            margin: 1em 0;
        }

        .post-meta {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            width: 100%;
            max-width: 720px;
            margin: 1em 0;
            font-size: 0.8em;
            color: #999;
        }

        .post-body {
            width: 100%;
            max-width: 720px;
            margin: 1em 0;
            font-size: 1.2em;
            line-height: 1.5;
            text-align: center;
            word-wrap: break-word;
        }

        .post-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">

        <main class="content">
            <?php if (isset($_GET['title']) && isset($_GET['body'])): ?>
                <article class="post">
                    <img src="<?php echo $_GET['image']; ?>" alt=""
                        class="post-image">
                    <h1 class="post-title">
                        <?php echo $_GET['title']; ?>
                    </h1>
                   <!--
                    // this is the author name commented out its not necessary to put the author name 
                      <div class="post-meta">
                        <span>
                            <?php echo $_GET['createdAt']; ?>
                        </span>
                    </div> -->
                    <p class="post-body">
                        <?php echo $_GET['body']; ?>
                    </p>
                </article>
            <?php else: ?>
                <p>Error: Post not found.</p>
            <?php endif; ?>
        </main>
        <footer>
            <?php include_once 'footer.php'; ?>
        </footer>
    </div>
</body>

</html>