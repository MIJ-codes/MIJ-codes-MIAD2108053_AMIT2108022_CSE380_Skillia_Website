<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Candidates - Skillia</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/search-candidates.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="../assets/js/main.js"></script>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="search-candidates-main">
    <section class="search-candidates-hero-section">
        <div class="search-candidates-hero-bg">
            <!-- Magnifying glass shapes -->
            <div class="search-magnifier-1"></div>
            <div class="search-magnifier-2"></div>
            
            <!-- User profile shapes -->
            <div class="user-profile-1"></div>
            <div class="user-profile-2"></div>
            
            <!-- Data stream lines -->
            <div class="data-stream"></div>
            <div class="data-stream"></div>
            <div class="data-stream"></div>
            
            <!-- Floating search icons -->
            <span class="search-icon-1"><i class="ri-search-line"></i></span>
            <span class="search-icon-2"><i class="ri-user-search-line"></i></span>
        </div>
        <div class="search-candidates-hero-content">
            <h1>Search <span>Candidates</span></h1>
            <p>Discover top talent for your organization. Use the search and filters below to find the best candidates.</p>
        </div>
    </section>

    <!-- Search Filters Section -->
    <section class="search-filters-section">
        <div class="container">
            <div class="filters-card">
                <h3><i class="ri-filter-3-line"></i> Search Filters</h3>
                <div class="filters-grid">
                    <div class="filter-group">
                        <label for="jobTitle">Job Title/Keywords</label>
                        <input type="text" id="jobTitle" placeholder="e.g. Frontend Developer, React, UI/UX">
                    </div>
                    <div class="filter-group">
                        <label for="location">Location</label>
                        <select id="location">
                            <option value="">Any Location</option>
                            <option value="dhaka">Dhaka</option>
                            <option value="chittagong">Chittagong</option>
                            <option value="sylhet">Sylhet</option>
                            <option value="remote">Remote</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="experience">Experience Level</label>
                        <select id="experience">
                            <option value="">Any Experience</option>
                            <option value="entry">Entry Level (0-2 years)</option>
                            <option value="mid">Mid Level (3-5 years)</option>
                            <option value="senior">Senior Level (5+ years)</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="skills">Skills</label>
                        <input type="text" id="skills" placeholder="e.g. JavaScript, Python, React">
                    </div>
                    <div class="filter-group">
                        <label for="availability">Availability</label>
                        <select id="availability">
                            <option value="">Any Availability</option>
                            <option value="immediate">Immediate</option>
                            <option value="2weeks">2 Weeks Notice</option>
                            <option value="1month">1 Month Notice</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="salary">Expected Salary</label>
                        <select id="salary">
                            <option value="">Any Salary</option>
                            <option value="20k-40k">20K - 40K BDT</option>
                            <option value="40k-60k">40K - 60K BDT</option>
                            <option value="60k-80k">60K - 80K BDT</option>
                            <option value="80k+">80K+ BDT</option>
                        </select>
                    </div>
                </div>
                <div class="filter-actions">
                    <button class="search-btn" disabled>
                        <i class="ri-search-line"></i>
                        Search Candidates (Coming Soon)
                    </button>
                    <button class="clear-btn" disabled>Clear Filters</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Candidate Results Section -->
    <section class="candidates-results-section">
        <div class="container">
            <div class="results-header">
                <h2>Top Candidates</h2>
                <div class="results-count">
                    <span>Showing <strong>12</strong> of <strong>2,847</strong> candidates</span>
                </div>
                <div class="sort-options">
                    <label for="sortBy">Sort by:</label>
                    <select id="sortBy" disabled>
                        <option value="relevance">Relevance</option>
                        <option value="experience">Experience</option>
                        <option value="skills">Skills Match</option>
                        <option value="recent">Recently Active</option>
                    </select>
                </div>
            </div>

            <div class="candidates-grid">
                <!-- Candidate Card 1 -->
                <div class="candidate-card">
                    <div class="candidate-header">
                        <div class="candidate-avatar">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face" alt="Ahmed Rahman">
                        </div>
                        <div class="candidate-info">
                            <h3>Ahmed Rahman</h3>
                            <p class="candidate-title">Senior Frontend Developer</p>
                            <p class="candidate-location"><i class="ri-map-pin-line"></i> Dhaka, Bangladesh</p>
                        </div>
                        <div class="candidate-status">
                            <span class="status-badge available">Available</span>
                        </div>
                    </div>
                    <div class="candidate-skills">
                        <span class="skill-tag">React</span>
                        <span class="skill-tag">JavaScript</span>
                        <span class="skill-tag">TypeScript</span>
                        <span class="skill-tag">Node.js</span>
                        <span class="skill-tag">UI/UX</span>
                    </div>
                    <div class="candidate-details">
                        <p class="experience"><i class="ri-time-line"></i> 5+ years experience</p>
                        <p class="salary"><i class="ri-money-dollar-circle-line"></i> 60K - 80K BDT</p>
                        <p class="availability"><i class="ri-calendar-line"></i> Available in 2 weeks</p>
                    </div>
                    <div class="candidate-actions">
                        <button class="view-profile-btn" disabled>View Profile</button>
                        <button class="contact-btn" disabled><i class="ri-message-3-line"></i> Contact</button>
                    </div>
                </div>

                <!-- Candidate Card 2 -->
                <div class="candidate-card">
                    <div class="candidate-header">
                        <div class="candidate-avatar">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face" alt="Fatima Khan">
                        </div>
                        <div class="candidate-info">
                            <h3>Fatima Khan</h3>
                            <p class="candidate-title">Full Stack Developer</p>
                            <p class="candidate-location"><i class="ri-map-pin-line"></i> Chittagong, Bangladesh</p>
                        </div>
                        <div class="candidate-status">
                            <span class="status-badge immediate">Immediate</span>
                        </div>
                    </div>
                    <div class="candidate-skills">
                        <span class="skill-tag">Python</span>
                        <span class="skill-tag">Django</span>
                        <span class="skill-tag">React</span>
                        <span class="skill-tag">PostgreSQL</span>
                        <span class="skill-tag">AWS</span>
                    </div>
                    <div class="candidate-details">
                        <p class="experience"><i class="ri-time-line"></i> 3 years experience</p>
                        <p class="salary"><i class="ri-money-dollar-circle-line"></i> 40K - 60K BDT</p>
                        <p class="availability"><i class="ri-calendar-line"></i> Available immediately</p>
                    </div>
                    <div class="candidate-actions">
                        <button class="view-profile-btn" disabled>View Profile</button>
                        <button class="contact-btn" disabled><i class="ri-message-3-line"></i> Contact</button>
                    </div>
                </div>

                <!-- Candidate Card 3 -->
                <div class="candidate-card">
                    <div class="candidate-header">
                        <div class="candidate-avatar">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face" alt="Rahim Ali">
                        </div>
                        <div class="candidate-info">
                            <h3>Rahim Ali</h3>
                            <p class="candidate-title">DevOps Engineer</p>
                            <p class="candidate-location"><i class="ri-map-pin-line"></i> Remote</p>
                        </div>
                        <div class="candidate-status">
                            <span class="status-badge available">Available</span>
                        </div>
                    </div>
                    <div class="candidate-skills">
                        <span class="skill-tag">Docker</span>
                        <span class="skill-tag">Kubernetes</span>
                        <span class="skill-tag">AWS</span>
                        <span class="skill-tag">Jenkins</span>
                        <span class="skill-tag">Linux</span>
                    </div>
                    <div class="candidate-details">
                        <p class="experience"><i class="ri-time-line"></i> 4 years experience</p>
                        <p class="salary"><i class="ri-money-dollar-circle-line"></i> 70K - 90K BDT</p>
                        <p class="availability"><i class="ri-calendar-line"></i> Available in 1 month</p>
                    </div>
                    <div class="candidate-actions">
                        <button class="view-profile-btn" disabled>View Profile</button>
                        <button class="contact-btn" disabled><i class="ri-message-3-line"></i> Contact</button>
                    </div>
                </div>

                <!-- Candidate Card 4 -->
                <div class="candidate-card">
                    <div class="candidate-header">
                        <div class="candidate-avatar">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face" alt="Aisha Begum">
                        </div>
                        <div class="candidate-info">
                            <h3>Aisha Begum</h3>
                            <p class="candidate-title">UI/UX Designer</p>
                            <p class="candidate-location"><i class="ri-map-pin-line"></i> Sylhet, Bangladesh</p>
                        </div>
                        <div class="candidate-status">
                            <span class="status-badge immediate">Immediate</span>
                        </div>
                    </div>
                    <div class="candidate-skills">
                        <span class="skill-tag">Figma</span>
                        <span class="skill-tag">Adobe XD</span>
                        <span class="skill-tag">Sketch</span>
                        <span class="skill-tag">Prototyping</span>
                        <span class="skill-tag">User Research</span>
                    </div>
                    <div class="candidate-details">
                        <p class="experience"><i class="ri-time-line"></i> 2 years experience</p>
                        <p class="salary"><i class="ri-money-dollar-circle-line"></i> 30K - 50K BDT</p>
                        <p class="availability"><i class="ri-calendar-line"></i> Available immediately</p>
                    </div>
                    <div class="candidate-actions">
                        <button class="view-profile-btn" disabled>View Profile</button>
                        <button class="contact-btn" disabled><i class="ri-message-3-line"></i> Contact</button>
                    </div>
                </div>

                <!-- Candidate Card 5 -->
                <div class="candidate-card">
                    <div class="candidate-header">
                        <div class="candidate-avatar">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop&crop=face" alt="Karim Hassan">
                        </div>
                        <div class="candidate-info">
                            <h3>Karim Hassan</h3>
                            <p class="candidate-title">Backend Developer</p>
                            <p class="candidate-location"><i class="ri-map-pin-line"></i> Dhaka, Bangladesh</p>
                        </div>
                        <div class="candidate-status">
                            <span class="status-badge available">Available</span>
                        </div>
                    </div>
                    <div class="candidate-skills">
                        <span class="skill-tag">Java</span>
                        <span class="skill-tag">Spring Boot</span>
                        <span class="skill-tag">MySQL</span>
                        <span class="skill-tag">Microservices</span>
                        <span class="skill-tag">REST API</span>
                    </div>
                    <div class="candidate-details">
                        <p class="experience"><i class="ri-time-line"></i> 6 years experience</p>
                        <p class="salary"><i class="ri-money-dollar-circle-line"></i> 80K - 100K BDT</p>
                        <p class="availability"><i class="ri-calendar-line"></i> Available in 2 weeks</p>
                    </div>
                    <div class="candidate-actions">
                        <button class="view-profile-btn" disabled>View Profile</button>
                        <button class="contact-btn" disabled><i class="ri-message-3-line"></i> Contact</button>
                    </div>
                </div>

                <!-- Candidate Card 6 -->
                <div class="candidate-card">
                    <div class="candidate-header">
                        <div class="candidate-avatar">
                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&h=150&fit=crop&crop=face" alt="Nadia Islam">
                        </div>
                        <div class="candidate-info">
                            <h3>Nadia Islam</h3>
                            <p class="candidate-title">Data Scientist</p>
                            <p class="candidate-location"><i class="ri-map-pin-line"></i> Remote</p>
                        </div>
                        <div class="candidate-status">
                            <span class="status-badge immediate">Immediate</span>
                        </div>
                    </div>
                    <div class="candidate-skills">
                        <span class="skill-tag">Python</span>
                        <span class="skill-tag">Machine Learning</span>
                        <span class="skill-tag">TensorFlow</span>
                        <span class="skill-tag">SQL</span>
                        <span class="skill-tag">Statistics</span>
                    </div>
                    <div class="candidate-details">
                        <p class="experience"><i class="ri-time-line"></i> 3 years experience</p>
                        <p class="salary"><i class="ri-money-dollar-circle-line"></i> 60K - 80K BDT</p>
                        <p class="availability"><i class="ri-calendar-line"></i> Available immediately</p>
                    </div>
                    <div class="candidate-actions">
                        <button class="view-profile-btn" disabled>View Profile</button>
                        <button class="contact-btn" disabled><i class="ri-message-3-line"></i> Contact</button>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button class="pagination-btn" disabled><i class="ri-arrow-left-s-line"></i> Previous</button>
                <div class="page-numbers">
                    <span class="page-number active">1</span>
                    <span class="page-number">2</span>
                    <span class="page-number">3</span>
                    <span class="page-number">...</span>
                    <span class="page-number">12</span>
                </div>
                <button class="pagination-btn" disabled>Next <i class="ri-arrow-right-s-line"></i></button>
            </div>
        </div>
    </section>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html> 