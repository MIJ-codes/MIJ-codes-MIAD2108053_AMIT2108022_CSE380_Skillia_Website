<<<<<<< HEAD
# Skillia Job Portal

## How to Run

1. Place the `Skillia` folder inside your XAMPP `htdocs` directory.
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Open your browser and go to: [http://localhost/Skillia/pages/home.php](http://localhost/Skillia/pages/home.php)
   - Or go to [http://localhost/Skillia/](http://localhost/Skillia/) if you want to use the index redirect.

## Folder Structure

```
Skillia/
  assets/
    css/style.css
    js/main.js
    images/
  includes/
    header.php
    footer.php
    db.php
  pages/
    home.php
    job-board.php
    categories.php
    about-us.php
    login.php
    register.php
    post-job.php
    dashboard.php
    company.php
    for-employers.php
    job-seekers.php
    career-resources.php
    contact-us.php
    privacy-policy.php
    terms-of-service.php
    help-center.php
    salary-guide.php
    recruitment-solutions.php
    pricing-plans.php
    enterprise-solutions.php
  index.php
  README.md
```

- **assets/**: CSS, JS, and images
- **includes/**: Reusable PHP files (header, footer, database connection)
- **pages/**: All main pages as PHP files
- **index.php**: Redirects to home page

---

You can edit any page in `pages/` and the header/footer in `includes/`. 

## Success Stories Table (for future dynamic stories)

Create this table in your MySQL database:

```sql
CREATE TABLE success_stories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  job_title VARCHAR(100) NOT NULL,
  company VARCHAR(100) NOT NULL,
  story TEXT NOT NULL,
  image_url VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
``` # my-repo
=======
# MIAD2108053_AMIT2108022_CSE380_Skillia_Website
>>>>>>> df0e371c02927e2461b31888a886f8688de0d121
# MIJ-codes-MIAD2108053_AMIT2108022_CSE380_Skillia_Website
