<!--This code was created by Dani Krossing, in his YouTube video "How to create a login system in PHP" and is used as a base to test the Authentication System -->
<!--Above comment: OUTDATED. Edit it with new author of source code-->
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>CompileCart</title>
        <?php
			include_once 'header.php';
		?>
  <!-- Page Wrapper -->
  <div class="page-wrapper">

    <!-- Post Slider
    <div class="post-slider">
      <h1 class="slider-title">Trending Posts</h1>
      <i class="fas fa-chevron-left prev"></i>
      <i class="fas fa-chevron-right next"></i>
      <div class="post-wrapper">
        <div class="post">
          <img src="images/image_1.png" alt="" class="slider-image">
          <div class="post-info">
            <h4><a href="single.html">One day your life will flash before your eyes</a></h4>
            <i class="far fa-user"> Awa Melvine</i>
            &nbsp;
            <i class="far fa-calendar"> Mar 8, 2019</i>
          </div>
        </div>
        <div class="post">
          <img src="images/image_1.png" alt="" class="slider-image">
          <div class="post-info">
            <h4><a href="single.html">One day your life will flash before your eyes</a></h4>
            <i class="far fa-user"> Awa Melvine</i>
            &nbsp;
            <i class="far fa-calendar"> Mar 8, 2019</i>
          </div>
        </div>
        <div class="post">
          <img src="images/image_1.png" alt="" class="slider-image">
          <div class="post-info">
            <h4><a href="single.html">One day your life will flash before your eyes</a></h4>
            <i class="far fa-user"> Awa Melvine</i>
            &nbsp;
            <i class="far fa-calendar"> Mar 8, 2019</i>
          </div>
        </div>
        <div class="post">
          <img src="images/image_1.png" alt="" class="slider-image">
          <div class="post-info">
            <h4><a href="single.html">One day your life will flash before your eyes</a></h4>
            <i class="far fa-user"> Awa Melvine</i>
            &nbsp;
            <i class="far fa-calendar"> Mar 8, 2019</i>
          </div>
        </div>
        <div class="post">
          <img src="images/image_1.png" alt="" class="slider-image">
          <div class="post-info">
            <h4><a href="single.html">One day your life will flash before your eyes</a></h4>
            <i class="far fa-user"> Awa Melvine</i>
            &nbsp;
            <i class="far fa-calendar"> Mar 8, 2019</i>
          </div>
        </div>
      </div>
    </div> -->
    <!-- // Post Slider -->

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

        <div class="post clearfix">
         <!-- <img src="images/image_3.png" alt="" class="post-image"> -->
          <div class="post-preview">
            <h2><a href="single.html">The strongest and sweetest songs yet remain to be sung</a></h2>
            <i class="far fa-user"> Awa Melvine</i>
            &nbsp;
            <i class="far fa-calendar"> Mar 11, 2019</i>
            <p class="preview-text">
            The company itself is a very successful company. 
            We can choose an exercise from the inventor of most of the exercises.
            </p>
            <a href="single.html" class="btn read-more">Read More</a>
          </div>
        </div>

        <?php
        /*
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
                <a href="single.html" class="btn read-more">Read More</a>
            </div>
        </div>
        <?php }} */?>
        

      </div>
      <!-- // Main Content -->

      <!--
      <div class="sidebar">
        <div class="section search">
          <h2 class="section-title">Search</h2>
          <form action="index.html" method="post">
            <input type="text" name="search-term" class="text-input" placeholder="Search...">
          </form>
        </div>
        <div class="section topics">
          <h2 class="section-title">Topics</h2>
          <ul>
            <li><a href="#">Poems</a></li>
            <li><a href="#">Quotes</a></li>
            <li><a href="#">Fiction</a></li>
            <li><a href="#">Biography</a></li>
            <li><a href="#">Motivation</a></li>
            <li><a href="#">Inspiration</a></li>
            <li><a href="#">Life Lessons</a></li>
          </ul>
        </div>
      </div>
      -->
    </div>
    <!-- // Content -->

  </div>
  <!-- // Page Wrapper -->
 	<?php 
		include_once 'footer.php';
	?>

</html>
