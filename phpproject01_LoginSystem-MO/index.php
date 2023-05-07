<!--This code was created by Dani Krossing, in his YouTube video "How to create a login system in PHP" and is used as a base to test the Authentication System -->
<!--Above comment: OUTDATED. Edit it with new author of source code-->
<!DOCTYPE html>
<html lang="en">

<head>
  <title>CompileCart</title>
  <script src="script.js"></script>
  <script>
    const templatePost = (post) => `
      <div class="post clearfix">
        <img src="${post.post_image}" alt="" class="post-image">
        <div class="post-preview">
          <h2>
            <a href="single.html">
                ${post.post_title}
            </a>
          </h2>
          <!--  <i class="far fa-user"> Awa Melvine</i> // this is the author name commented out-->
          &nbsp;
          <i class="far fa-calendar">
            ${post.created_at}
          </i>
          <p class="preview-text">
          ${post.post_body.slice(0, 50)}
          </p>
          <a href="single.php?title=${post.post_title}&body=${post.post_body}&image=${post.post_image}&createdAt=${post.created_at}" class="btn read-more">Read More</a>
        </div>
      </div>
      `;

    function onPostsReady(posts) {
      console.log(posts);
      const postContainer = document.getElementById('posts-container');
      posts.forEach((post) => {
        postContainer.innerHTML += templatePost(post);
      });
    }

    window.onload = () => {
      SendGetAllPostsRequest(onPostsReady);
    };
  </script>
</head>


<body>
  <?php
  include_once 'header.php';
  ?>

  <!-- Page Wrapper -->
  <div class="page-wrapper">

    <!-- Main Content (By Abdelmalek Benaissa) -->
    <div class="main-content-compilecart">
      <h1 class="welcome-title">Welcome!</h1>
      <p class="main-text">
        For the newcomers who are visiting this website for the first time,
        let me introduce you to our Meal Planner service called CompileCart.
        CompileCart is a software that allows any register user to
        select a recipe for a meal that they want to cook for the day. The
        software will then return the user a list of the ingredients needed
        to create the meal. There will also be a price comparison chart
        that shows the most affordable places to purchase the ingredients
        in. Registered users can also share the food that they plan to make
        by filling out a blogging form. Any blog posts that has been
        published can be seen at the bottom of our home page. I hope you
        enjoy your stay in this website, and make good use of our services!
      </p>
    </div>

    <!-- Content -->
    <div class="content clearfix">

      <!-- Main Content -->
      <div class="main-content">
        <h1 class="recent-post-title">Recent Posts</h1>
        <div id="posts-container">

        </div>

        <?php
        /*
        // Mohamed: To display the posts, where the posts are intended to be displayed:
        // Abdelmalek: You need to fix the way you close the first php tag
        // It is invalid syntax, try looking at header.php for an example
        require_once('../sampleFiles/path.inc');
        require_once('../sampleFiles/get_host_info.inc');
        require_once('../sampleFiles/rabbitMQLib.inc');
        $client = new rabbitMQClient("../database/db.ini", "dbServer");
        $request['type'] = 'get_posts';
        $response = $client->send_request($request);
        if (!empty($response)) {
        $posts = $response;
        foreach ($posts as $post) {
        ?>
        <div class="post clearfix">
        <img src="<?php echo $post['image']; ?>" alt="" class="post-image">
        <div class="post-preview">
        <h2><a href="#"><?php echo $post['title']; ?></a></h2>
        <i class="far fa-user"><?php echo $post['author']; ?></i>
        &nbsp;
        <i class="far fa-calendar"> <?php echo $post['created_at']; ?></i>
        <p class="preview-text"><?php echo $post['body']; ?></p>
        <a href="single.php" class="btn read-more">Read More</a>
        </div>
        </div>
        <?php }} */?>


      </div>
      <!-- // Main Content -->

    </div>
    <!-- // Content -->

  </div>
  <!-- // Page Wrapper -->
  <?php
  include_once 'footer.php';
  ?>
</body>

</html>