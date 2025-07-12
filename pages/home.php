<?php $currentPage = 'home'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Skillia - Home</title>
  <link rel="stylesheet" href="/Skillia/assets/css/style.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
  <script src="/Skillia/assets/js/main.js"></script>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div id="main" class="fade-in" style="background: var(--bg-light); min-height: 100vh;">
  <div id="page1">
    <div id="block1">
      <div class="container">
        <div id="hbox">
          <h1>Don't lose your Bela Bose anymore because of jobs.</h1>
        </div>
        <div id="tbox">
          <p>
            Find the best paying jobs from country's biggest job site.<br />From
            thousands of jobs find your perfect match.
          </p>
        </div>
        <div id="sbox">
          <div id="outer">
            <input type="text" id="type" placeholder="Search for jobs..." />
            <div id="findJobButton">Find Job</div>
          </div>
        </div>
      </div>
    </div>
    <div id="block2">
      <img src="/Skillia/assets/images/first_page_photo.png" alt="Job Search Illustration" />
    </div>
  </div>
  <div id="page2">
    <div id="p2h">
      <h1>Categories</h1>
      <h1>See all</h1>
    </div>
    <div id="cbox">
      <div class="card"><img src="/Skillia/assets/images/Programming_&_Tech_Logo.png" alt="Programming & Tech" /><p>Programming & <br />Tech</p></div>
      <div class="card"><img src="/Skillia/assets/images/Graphics_&_Design_Logo.png" alt="Graphics & Design" /><p>Graphics & Design</p></div>
      <div class="card"><img src="/Skillia/assets/images/Digital_Marketing_Logo.png" alt="Digital Marketing" /><p>Digital Marketing</p></div>
      <div class="card"><img src="/Skillia/assets/images/Writing_&_Translation_Logo.png" alt="Writing & Translation" /><p>Writing & Translation</p></div>
      <div class="card"><img src="/Skillia/assets/images/Video_&_Animation_Logo.png" alt="Video & Animation" /><p>Video & Animation</p></div>
      <div class="card"><img src="/Skillia/assets/images/AI_Services_Logo.png" alt="AI Services" /><p>AI Services</p></div>
      <div class="card"><img src="/Skillia/assets/images/Music_&_Audio_Logo.png" alt="Music & Audio" /><p>Music & Audio</p></div>
      <div class="card"><img src="/Skillia/assets/images/Business_Logo.png" alt="Business" /><p>Business</p></div>
      <div class="card"><img src="/Skillia/assets/images/Consulting_Logo.png" alt="Consulting" /><p>Consulting</p></div>
    </div>
    <div id="popularbox">
      <h1>Popular Services</h1>
    </div>
    <div id="pbox">
      <div class="bigcard"><p>Website Development</p><img src="https://fiverr-res.cloudinary.com/q_auto,f_auto,w_188,dpr_2.0/v1/attachments/generic_asset/asset/798403f5b92b1b5af997acc704a3d21c-1702465156477/website-development.png" alt="Website Development" /></div>
      <div class="bigcard"><p>Video Editing</p><img src="https://fiverr-res.cloudinary.com/q_auto,f_auto,w_188,dpr_2.0/v1/attachments/generic_asset/asset/798403f5b92b1b5af997acc704a3d21c-1702465156494/video-editing.png" alt="Video Editing" /></div>
      <div class="bigcard"><p>Software Development</p><img src="https://fiverr-res.cloudinary.com/q_auto,f_auto,w_188,dpr_2.0/v1/attachments/generic_asset/asset/798403f5b92b1b5af997acc704a3d21c-1702465156476/software-development.png" alt="Software Development" /></div>
      <div class="bigcard"><p>SEO</p><img src="https://fiverr-res.cloudinary.com/q_auto,f_auto,w_188,dpr_2.0/v1/attachments/generic_asset/asset/798403f5b92b1b5af997acc704a3d21c-1702465156488/seo.png" alt="SEO" /></div>
      <div class="bigcard"><p>Architecture & Interior Design</p><img src="https://fiverr-res.cloudinary.com/q_auto,f_auto,w_188,dpr_2.0/v1/attachments/generic_asset/asset/798403f5b92b1b5af997acc704a3d21c-1702465156473/architecture-design.png" alt="Architecture & Interior Design" /></div>
      <div class="bigcard"><p>Book Design</p><img src="https://fiverr-res.cloudinary.com/q_auto,f_auto,w_188,dpr_2.0/v1/attachments/generic_asset/asset/af48c6702af221956ea7adf0055854e6-1745826082297/Book%20Design.png" alt="Book Design" /></div>
    </div>
  </div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html> 