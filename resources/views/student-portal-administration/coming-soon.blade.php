@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="coming-soon-container">
                <div class="coming-soon-card">
                    <div class="coming-soon-header">
                        <div class="icon-container">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h1 class="coming-soon-title">Student Portal Administration</h1>
                        <p class="coming-soon-subtitle">Management & Configuration Center</p>
                    </div>

                    <div class="coming-soon-content">
                        <div class="status-badge">
                            <i class="fas fa-clock"></i>
                            <span>Coming Soon</span>
                        </div>

                        <div class="description">
                            <p>We're working hard to bring you a comprehensive Student Portal Administration system. This powerful management center will allow you to:</p>
                        </div>

                        <div class="features-grid">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-users-cog"></i>
                                </div>
                                <h3>User Management</h3>
                                <p>Manage student portal access, roles, and permissions</p>
                            </div>

                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-palette"></i>
                                </div>
                                <h3>Portal Customization</h3>
                                <p>Customize portal themes, layouts, and branding</p>
                            </div>

                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h3>Analytics & Reports</h3>
                                <p>Monitor portal usage and generate detailed reports</p>
                            </div>

                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <h3>Notifications</h3>
                                <p>Manage system notifications and announcements</p>
                            </div>

                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h3>Security Settings</h3>
                                <p>Configure security policies and access controls</p>
                            </div>

                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <h3>System Configuration</h3>
                                <p>Configure portal modules and system settings</p>
                            </div>
                        </div>

                        <div class="timeline-section">
                            <h3>Development Timeline</h3>
                            <div class="timeline">
                                <div class="timeline-item completed">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h4>Phase 1: Planning & Design</h4>
                                        <p>System architecture and UI/UX design</p>
                                        <span class="status">Completed</span>
                                    </div>
                                </div>
                                <div class="timeline-item in-progress">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h4>Phase 2: Core Development</h4>
                                        <p>Building core administration features</p>
                                        <span class="status">In Progress</span>
                                    </div>
                                </div>
                                <div class="timeline-item upcoming">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h4>Phase 3: Testing & Launch</h4>
                                        <p>Quality assurance and system deployment</p>
                                        <span class="status">Upcoming</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="contact-section">
                            <h3>Stay Updated</h3>
                            <p>For updates on the Student Portal Administration development, please contact your system administrator.</p>
                            <div class="contact-buttons">
                                <a href="/home" class="btn btn-back">
                                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                                </a>
                                <a href="https://educims.com/contact.html" target="_blank" class="btn btn-contact">
                                    <i class="fas fa-envelope"></i> Contact Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.coming-soon-container {
    min-height: 100vh;
    padding: 2rem 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
}

.coming-soon-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.coming-soon-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 1;
    overflow: hidden;
}

.coming-soon-header {
    text-align: center;
    padding: 3rem 2rem 2rem;
    background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
    color: white;
    position: relative;
}

.coming-soon-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
}

.icon-container {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.5rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 1;
}

.icon-container i {
    font-size: 3rem;
    color: white;
}

.coming-soon-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.coming-soon-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin: 0;
    position: relative;
    z-index: 1;
}

.coming-soon-content {
    padding: 3rem 2rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
}

.description {
    text-align: center;
    margin-bottom: 3rem;
}

.description p {
    font-size: 1.1rem;
    color: #666;
    line-height: 1.6;
    max-width: 600px;
    margin: 0 auto;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.feature-card {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid rgba(111, 66, 193, 0.1);
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.feature-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feature-icon i {
    font-size: 1.8rem;
    color: white;
}

.feature-card h3 {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #333;
}

.feature-card p {
    color: #666;
    line-height: 1.5;
    margin: 0;
}

.timeline-section {
    margin-bottom: 3rem;
}

.timeline-section h3 {
    text-align: center;
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 2rem;
    color: #333;
}

.timeline {
    max-width: 600px;
    margin: 0 auto;
}

.timeline-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 2rem;
    position: relative;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 15px;
    top: 30px;
    width: 2px;
    height: calc(100% + 2rem);
    background: #e0e0e0;
}

.timeline-marker {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 1.5rem;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
}

.timeline-item.completed .timeline-marker {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.timeline-item.in-progress .timeline-marker {
    background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
}

.timeline-item.upcoming .timeline-marker {
    background: #e0e0e0;
}

.timeline-content h4 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
}

.timeline-content p {
    color: #666;
    margin-bottom: 0.5rem;
}

.timeline-content .status {
    font-size: 0.9rem;
    font-weight: 500;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    display: inline-block;
}

.timeline-item.completed .status {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.timeline-item.in-progress .status {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.timeline-item.upcoming .status {
    background: rgba(224, 224, 224, 0.5);
    color: #666;
}

.contact-section {
    text-align: center;
    padding: 2rem;
    background: rgba(111, 66, 193, 0.05);
    border-radius: 15px;
}

.contact-section h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #333;
}

.contact-section p {
    color: #666;
    margin-bottom: 2rem;
}

.contact-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    padding: 0.75rem 2rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    border: none;
}

.btn-back {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    color: white;
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    color: white;
    text-decoration: none;
}

.btn-contact {
    background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
    color: white;
}

.btn-contact:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(111, 66, 193, 0.3);
    color: white;
    text-decoration: none;
}

@media (max-width: 768px) {
    .coming-soon-title {
        font-size: 2rem;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .contact-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .btn {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}
</style>
@endsection
