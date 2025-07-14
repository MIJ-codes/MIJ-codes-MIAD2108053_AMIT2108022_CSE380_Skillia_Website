<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<?php $currentPage = 'categories'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skillia - Browse Job Categories</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/categories.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="categories-main">
    <!-- Hero Section -->
    <section class="categories-hero-section">
        <div class="categories-hero-content">
            <h1 class="categories-hero-title">Browse Jobs by Category</h1>
            <p class="categories-hero-subtitle">Find your perfect opportunity across creative, technical, and business fields</p>
            <div class="categories-search-bar">
                <input type="text" class="categories-search-input" placeholder="Search categories...">
                <select class="categories-filter" data-type="location">
                    <option value="">All Locations</option>
                    <option value="remote">Remote</option>
                    <option value="onsite">On-site</option>
                    <option value="hybrid">Hybrid</option>
                </select>
                <select class="categories-filter" data-type="experience">
                    <option value="">All Experience Levels</option>
                    <option value="entry">Entry Level</option>
                    <option value="mid">Mid Level</option>
                    <option value="senior">Senior Level</option>
                </select>
            </div>
        </div>
    </section>

    <!-- Filter & Sort Section -->
    <section class="categories-filter-section">
        <div class="categories-filters">
            <button class="categories-filter-btn active">All Categories</button>
            <button class="categories-filter-btn">Most Popular</button>
            <button class="categories-filter-btn">Remote Available</button>
            <button class="categories-filter-btn">Freelance</button>
            <button class="categories-filter-btn">Full-time</button>
        </div>
        <div class="categories-sort">
            <span>Sort by:</span>
            <select class="categories-sort-select">
                <option value="az">A-Z</option>
                <option value="job-count">Job Count</option>
                <option value="salary">Salary Range</option>
            </select>
        </div>
    </section>

    <!-- Categories Grid -->
    <section class="categories-grid-section">
        <div class="categories-grid">
            <!-- Future: Loop through categories from database here -->
            <div class="category-card" data-category="programming-tech" data-job-count="2847" data-remote="true">
                <div class="category-icon"><i class="ri-code-s-slash-line"></i></div>
                <div class="category-content">
                    <h3>Programming & Tech</h3>
                    <span class="category-badge remote">Remote Available</span>
                    <div class="category-jobs">2,847 jobs available</div>
                    <div class="category-desc">Full-stack development, mobile apps, web development, and software engineering</div>
                    <div class="category-roles">Full Stack Developer • Frontend Developer • Backend Developer • Mobile App Developer</div>
                    <div class="category-salary">$60,000 - $130,000</div>
                </div>
            </div>
            <div class="category-card" data-category="graphics-design" data-job-count="1523">
                <div class="category-icon"><i class="ri-shapes-line"></i></div>
                <div class="category-content">
                    <h3>Graphics & Design</h3>
                    <div class="category-jobs">1,523 jobs available</div>
                    <div class="category-desc">Visual design, branding, UI/UX design, and creative direction</div>
                    <div class="category-roles">Graphic Designer • UI/UX Designer • Brand Designer • Illustrator</div>
                    <div class="category-salary">$40,000 - $85,000</div>
                </div>
            </div>
            <div class="category-card" data-category="digital-marketing" data-job-count="1892">
                <div class="category-icon"><i class="ri-presentation-line"></i></div>
                <div class="category-content">
                    <h3>Digital Marketing</h3>
                    <div class="category-jobs">1,892 jobs available</div>
                    <div class="category-desc">SEO, social media marketing, PPC campaigns, and content strategy</div>
                    <div class="category-roles">Digital Marketing Manager • SEO Specialist • Social Media Manager • PPC Expert</div>
                    <div class="category-salary">$45,000 - $95,000</div>
                </div>
            </div>
            <div class="category-card" data-category="writing-translation" data-job-count="967">
                <div class="category-icon"><i class="ri-translate-2"></i></div>
                <div class="category-content">
                    <h3>Writing & Translation</h3>
                    <div class="category-jobs">967 jobs available</div>
                    <div class="category-desc">Content writing, copywriting, technical writing, and language translation</div>
                    <div class="category-roles">Content Writer • Copywriter • Technical Writer • Translator</div>
                    <div class="category-salary">$35,000 - $75,000</div>
                </div>
            </div>
            <div class="category-card" data-category="video-animation" data-job-count="743">
                <div class="category-icon"><i class="ri-video-add-line"></i></div>
                <div class="category-content">
                    <h3>Video & Animation</h3>
                    <div class="category-jobs">743 jobs available</div>
                    <div class="category-desc">Motion graphics, video editing, 3D animation, and multimedia production</div>
                    <div class="category-roles">Video Editor • Motion Graphics Designer • 3D Animator • Multimedia Producer</div>
                    <div class="category-salary">$40,000 - $80,000</div>
                </div>
            </div>
            <div class="category-card hot" data-category="ai-services" data-job-count="1234">
                <div class="category-icon"><i class="ri-robot-2-line"></i></div>
                <div class="category-content">
                    <h3>AI Services <span class="category-badge hot">🔥 Hot Category</span></h3>
                    <div class="category-jobs">1,234 jobs available</div>
                    <div class="category-desc">Machine learning, AI development, data science, and automation</div>
                    <div class="category-roles">AI Engineer • Machine Learning Engineer • Data Scientist • AI Researcher</div>
                    <div class="category-salary">$70,000 - $150,000</div>
                </div>
            </div>
            <div class="category-card" data-category="music-audio" data-job-count="456">
                <div class="category-icon"><i class="ri-music-2-line"></i></div>
                <div class="category-content">
                    <h3>Music & Audio</h3>
                    <div class="category-jobs">456 jobs available</div>
                    <div class="category-desc">Audio production, sound design, music composition, and podcast editing</div>
                    <div class="category-roles">Audio Engineer • Sound Designer • Music Producer • Podcast Editor</div>
                    <div class="category-salary">$35,000 - $70,000</div>
                </div>
            </div>
            <div class="category-card" data-category="business" data-job-count="2156">
                <div class="category-icon"><i class="ri-briefcase-4-line"></i></div>
                <div class="category-content">
                    <h3>Business</h3>
                    <div class="category-jobs">2,156 jobs available</div>
                    <div class="category-desc">Business analysis, project management, operations, and strategy consulting</div>
                    <div class="category-roles">Business Analyst • Project Manager • Operations Manager • Strategy Consultant</div>
                    <div class="category-salary">$50,000 - $110,000</div>
                </div>
            </div>
            <div class="category-card" data-category="consulting" data-job-count="892">
                <div class="category-icon"><i class="ri-hand-coin-line"></i></div>
                <div class="category-content">
                    <h3>Consulting</h3>
                    <div class="category-jobs">892 jobs available</div>
                    <div class="category-desc">Management consulting, IT consulting, financial advisory, and specialized expertise</div>
                    <div class="category-roles">Management Consultant • IT Consultant • Business Advisor • Strategy Consultant</div>
                    <div class="category-salary">$55,000 - $120,000</div>
                </div>
            </div>
            <div class="category-card" data-category="data-analytics" data-job-count="1345">
                <div class="category-icon"><i class="ri-bar-chart-2-line"></i></div>
                <div class="category-content">
                    <h3>Data & Analytics</h3>
                    <div class="category-jobs">1,345 jobs available</div>
                    <div class="category-desc">Data analysis, business intelligence, statistical modeling, and reporting</div>
                    <div class="category-roles">Data Analyst • Business Intelligence Analyst • Data Scientist • Reporting Specialist</div>
                    <div class="category-salary">$55,000 - $120,000</div>
                </div>
            </div>
            <div class="category-card" data-category="sales-customer-success" data-job-count="1678">
                <div class="category-icon"><i class="ri-arrow-up-line"></i></div>
                <div class="category-content">
                    <h3>Sales & Customer Success</h3>
                    <div class="category-jobs">1,678 jobs available</div>
                    <div class="category-desc">Sales development, account management, customer success, and business development</div>
                    <div class="category-roles">Sales Representative • Account Manager • Customer Success Manager • BDR</div>
                    <div class="category-salary">$40,000 - $90,000</div>
                </div>
            </div>
            <div class="category-card" data-category="administrative-support" data-job-count="1234">
                <div class="category-icon"><i class="ri-clipboard-line"></i></div>
                <div class="category-content">
                    <h3>Administrative Support</h3>
                    <div class="category-jobs">1,234 jobs available</div>
                    <div class="category-desc">Virtual assistance, data entry, administrative tasks, and office support</div>
                    <div class="category-roles">Virtual Assistant • Data Entry Specialist • Administrative Assistant • Office Manager</div>
                    <div class="category-salary">$35,000 - $65,000</div>
                </div>
            </div>
            <div class="category-card" data-category="finance-accounting" data-job-count="1567">
                <div class="category-icon"><i class="ri-currency-dollar-circle-line"></i></div>
                <div class="category-content">
                    <h3>Finance & Accounting</h3>
                    <div class="category-jobs">1,567 jobs available</div>
                    <div class="category-desc">Financial planning, bookkeeping, tax preparation, and investment analysis</div>
                    <div class="category-roles">Accountant • Financial Analyst • Bookkeeper • Tax Specialist</div>
                    <div class="category-salary">$45,000 - $95,000</div>
                </div>
            </div>
            <div class="category-card" data-category="healthcare-medical" data-job-count="2234">
                <div class="category-icon"><i class="ri-stethoscope-line"></i></div>
                <div class="category-content">
                    <h3>Healthcare & Medical</h3>
                    <div class="category-jobs">2,234 jobs available</div>
                    <div class="category-desc">Medical services, healthcare administration, telemedicine, and wellness</div>
                    <div class="category-roles">Nurse • Medical Assistant • Healthcare Administrator • Telehealth Specialist</div>
                    <div class="category-salary">$40,000 - $85,000</div>
                </div>
            </div>
            <div class="category-card" data-category="education-training" data-job-count="1789">
                <div class="category-icon"><i class="ri-graduation-cap-line"></i></div>
                <div class="category-content">
                    <h3>Education & Training</h3>
                    <div class="category-jobs">1,789 jobs available</div>
                    <div class="category-desc">Online tutoring, course creation, educational content, and training programs</div>
                    <div class="category-roles">Online Tutor • Course Creator • Training Specialist • Educational Content Writer</div>
                    <div class="category-salary">$35,000 - $70,000</div>
                </div>
            </div>
            <div class="category-card" data-category="legal-services" data-job-count="834">
                <div class="category-icon"><i class="ri-gavel-line"></i></div>
                <div class="category-content">
                    <h3>Legal Services</h3>
                    <div class="category-jobs">834 jobs available</div>
                    <div class="category-desc">Legal research, paralegal services, contract review, and legal writing</div>
                    <div class="category-roles">Paralegal • Legal Researcher • Contract Specialist • Legal Writer</div>
                    <div class="category-salary">$40,000 - $80,000</div>
                </div>
            </div>
            <div class="category-card" data-category="engineering-architecture" data-job-count="1456">
                <div class="category-icon"><i class="ri-building-4-line"></i></div>
                <div class="category-content">
                    <h3>Engineering & Architecture</h3>
                    <div class="category-jobs">1,456 jobs available</div>
                    <div class="category-desc">CAD design, engineering consulting, architectural planning, and technical drawing</div>
                    <div class="category-roles">CAD Designer • Civil Engineer • Architect • Technical Drafter</div>
                    <div class="category-salary">$55,000 - $105,000</div>
                </div>
            </div>
            <div class="category-card" data-category="photography-videography" data-job-count="678">
                <div class="category-icon"><i class="ri-camera-3-line"></i></div>
                <div class="category-content">
                    <h3>Photography & Videography</h3>
                    <div class="category-jobs">678 jobs available</div>
                    <div class="category-desc">Event photography, product photography, video production, and photo editing</div>
                    <div class="category-roles">Photographer • Video Producer • Photo Editor • Event Videographer</div>
                    <div class="category-salary">$30,000 - $75,000</div>
                </div>
            </div>
            <div class="category-card" data-category="ecommerce-retail" data-job-count="1923">
                <div class="category-icon"><i class="ri-shopping-cart-2-line"></i></div>
                <div class="category-content">
                    <h3>E-commerce & Retail</h3>
                    <div class="category-jobs">1,923 jobs available</div>
                    <div class="category-desc">Online store management, product listing, inventory management, and retail support</div>
                    <div class="category-roles">E-commerce Manager • Product Lister • Inventory Specialist • Online Store Assistant</div>
                    <div class="category-salary">$35,000 - $70,000</div>
                </div>
            </div>
            <div class="category-card" data-category="human-resources" data-job-count="1234">
                <div class="category-icon"><i class="ri-user-settings-line"></i></div>
                <div class="category-content">
                    <h3>Human Resources</h3>
                    <div class="category-jobs">1,234 jobs available</div>
                    <div class="category-desc">Talent acquisition, HR consulting, employee relations, and workforce management</div>
                    <div class="category-roles">HR Specialist • Recruiter • HR Consultant • Workforce Analyst</div>
                    <div class="category-salary">$45,000 - $85,000</div>
                </div>
            </div>
            <div class="category-card" data-category="real-estate" data-job-count="567">
                <div class="category-icon"><i class="ri-home-4-line"></i></div>
                <div class="category-content">
                    <h3>Real Estate</h3>
                    <div class="category-jobs">567 jobs available</div>
                    <div class="category-desc">Property management, real estate research, listing services, and market analysis</div>
                    <div class="category-roles">Real Estate Assistant • Property Manager • Market Researcher • Listing Specialist</div>
                    <div class="category-salary">$35,000 - $80,000</div>
                </div>
            </div>
            <div class="category-card hot" data-category="cybersecurity" data-job-count="1345">
                <div class="category-icon"><i class="ri-shield-keyhole-line"></i></div>
                <div class="category-content">
                    <h3>Cybersecurity <span class="category-badge hot">🔥 Hot Category</span></h3>
                    <div class="category-jobs">1,345 jobs available</div>
                    <div class="category-desc">Security analysis, penetration testing, compliance auditing, and risk assessment</div>
                    <div class="category-roles">Security Analyst • Penetration Tester • Compliance Specialist • Risk Assessor</div>
                    <div class="category-salary">$65,000 - $140,000</div>
                </div>
            </div>
            <div class="category-card" data-category="gaming-entertainment" data-job-count="789">
                <div class="category-icon"><i class="ri-gamepad-line"></i></div>
                <div class="category-content">
                    <h3>Gaming & Entertainment</h3>
                    <div class="category-jobs">789 jobs available</div>
                    <div class="category-desc">Game development, character design, game testing, and entertainment content</div>
                    <div class="category-roles">Game Developer • Character Designer • Game Tester • Entertainment Writer</div>
                    <div class="category-salary">$40,000 - $90,000</div>
                </div>
            </div>
            <div class="category-card" data-category="mobile-app-development" data-job-count="1567">
                <div class="category-icon"><i class="ri-smartphone-line"></i></div>
                <div class="category-content">
                    <h3>Mobile App Development</h3>
                    <div class="category-jobs">1,567 jobs available</div>
                    <div class="category-desc">iOS development, Android development, cross-platform apps, and mobile UI/UX</div>
                    <div class="category-roles">iOS Developer • Android Developer • Mobile UI Designer • App Tester</div>
                    <div class="category-salary">$60,000 - $125,000</div>
                </div>
            </div>
            <div class="category-card hot" data-category="blockchain-crypto" data-job-count="456">
                <div class="category-icon"><i class="ri-bit-coin-line"></i></div>
                <div class="category-content">
                    <h3>Blockchain & Cryptocurrency <span class="category-badge hot">🔥 Hot Category</span></h3>
                    <div class="category-jobs">456 jobs available</div>
                    <div class="category-desc">Smart contract development, DeFi projects, NFT creation, and blockchain consulting</div>
                    <div class="category-roles">Blockchain Developer • Smart Contract Developer • Crypto Analyst • DeFi Specialist</div>
                    <div class="category-salary">$70,000 - $160,000</div>
                </div>
            </div>
            <div class="category-card" data-category="social-media-management" data-job-count="1234">
                <div class="category-icon"><i class="ri-hashtag"></i></div>
                <div class="category-content">
                    <h3>Social Media Management</h3>
                    <div class="category-jobs">1,234 jobs available</div>
                    <div class="category-desc">Social media strategy, content creation, community management, and influencer marketing</div>
                    <div class="category-roles">Social Media Manager • Content Creator • Community Manager • Influencer Coordinator</div>
                    <div class="category-salary">$35,000 - $65,000</div>
                </div>
            </div>
            <div class="category-card new" data-category="virtual-reality-ar" data-job-count="234">
                <div class="category-icon"><i class="ri-vr-line"></i></div>
                <div class="category-content">
                    <h3>Virtual Reality & AR <span class="category-badge new">New Category</span></h3>
                    <div class="category-jobs">234 jobs available</div>
                    <div class="category-desc">VR development, AR applications, 3D modeling, and immersive experiences</div>
                    <div class="category-roles">VR Developer • AR Developer • 3D Modeler • UX Designer (VR/AR)</div>
                    <div class="category-salary">$65,000 - $130,000</div>
                </div>
            </div>
            <div class="category-card" data-category="research-analysis" data-job-count="1123">
                <div class="category-icon"><i class="ri-search-eye-line"></i></div>
                <div class="category-content">
                    <h3>Research & Analysis</h3>
                    <div class="category-jobs">1,123 jobs available</div>
                    <div class="category-desc">Market research, data analysis, academic research, and business intelligence</div>
                    <div class="category-roles">Market Researcher • Research Analyst • Business Intelligence Analyst • Academic Researcher</div>
                    <div class="category-salary">$45,000 - $85,000</div>
                </div>
            </div>
            <div class="category-card" data-category="quality-assurance-testing" data-job-count="987">
                <div class="category-icon"><i class="ri-bug-line"></i></div>
                <div class="category-content">
                    <h3>Quality Assurance & Testing</h3>
                    <div class="category-jobs">987 jobs available</div>
                    <div class="category-desc">Software testing, QA automation, user testing, and quality control</div>
                    <div class="category-roles">QA Tester • Automation Engineer • User Experience Tester • Quality Analyst</div>
                    <div class="category-salary">$45,000 - $80,000</div>
                </div>
            </div>
            <div class="category-card" data-category="supply-chain-logistics" data-job-count="1345">
                <div class="category-icon"><i class="ri-truck-line"></i></div>
                <div class="category-content">
                    <h3>Supply Chain & Logistics</h3>
                    <div class="category-jobs">1,345 jobs available</div>
                    <div class="category-desc">Supply chain management, logistics coordination, inventory planning, and procurement</div>
                    <div class="category-roles">Supply Chain Analyst • Logistics Coordinator • Procurement Specialist • Inventory Manager</div>
                    <div class="category-salary">$45,000 - $85,000</div>
                </div>
            </div>
            <div class="category-card" data-category="nonprofit-social-impact" data-job-count="678">
                <div class="category-icon"><i class="ri-heart-2-line"></i></div>
                <div class="category-content">
                    <h3>Nonprofit & Social Impact</h3>
                    <div class="category-jobs">678 jobs available</div>
                    <div class="category-desc">Grant writing, fundraising, program management, and social impact consulting</div>
                    <div class="category-roles">Grant Writer • Fundraising Specialist • Program Manager • Social Impact Consultant</div>
                    <div class="category-salary">$35,000 - $70,000</div>
                </div>
            </div>
            <div class="category-card" data-category="environmental-sustainability" data-job-count="456">
                <div class="category-icon"><i class="ri-leaf-line"></i></div>
                <div class="category-content">
                    <h3>Environmental & Sustainability</h3>
                    <div class="category-jobs">456 jobs available</div>
                    <div class="category-desc">Environmental consulting, sustainability reporting, green technology, and conservation</div>
                    <div class="category-roles">Environmental Consultant • Sustainability Analyst • Conservation Specialist • Green Tech Developer</div>
                    <div class="category-salary">$40,000 - $80,000</div>
                </div>
            </div>
            <!-- End categories loop -->
        </div>
    </section>

    <!-- Trending Categories Section (placeholder for backend) -->
    <section class="categories-trending-section">
        <h2>Trending Categories</h2>
        <!-- Future: Loop through trending categories from backend here -->
        <div class="categories-trending-list">
            <!-- Example trending category -->
            <div class="trending-category-card">
                <span class="trending-category-name">AI Services</span>
                <span class="trending-growth">+18% this month</span>
                <span class="category-badge hot">🔥 Hot Category</span>
            </div>
            <!-- ...more trending categories... -->
        </div>
        <div class="categories-trending-note">New jobs added daily</div>
    </section>

    <!-- Quick Actions & Career Resources Section (placeholder for backend) -->
    <section class="categories-actions-section">
        <div class="categories-actions-grid">
            <div class="categories-action-card">
                <h3>Create Job Alert</h3>
                <p>Get notified when new jobs are posted in your favorite categories.</p>
                <a href="job-alerts.php" class="categories-action-btn">Set Job Alert</a>
            </div>
            <div class="categories-action-card">
                <h3>Browse Jobs</h3>
                <p>Preview sample jobs for each category and see what fits you best.</p>
                <a href="job-board.php" class="categories-action-btn">Browse Jobs</a>
            </div>
            <div class="categories-action-card">
                <h3>Salary Calculator</h3>
                <p>Estimate your earning potential by category and experience level.</p>
                <a href="salary-guide.php#calculator" class="categories-action-btn">Calculate Salary</a>
            </div>
        </div>
        <div class="categories-career-resources">
            <h3><a href="career-resources.php" style="color:inherit;text-decoration:underline;">Career Resources</a></h3>
            <ul>
                <li>Skills in Demand by Category</li>
                <li>Career Transition Guides</li>
                <li>Certification Recommendations</li>
            </ul>
        </div>
    </section>
</div>

<script src="../assets/js/main.js"></script>
<script src="../assets/js/categories.js"></script>
<?php include '../includes/footer.php'; ?> 
</body>
</html> 