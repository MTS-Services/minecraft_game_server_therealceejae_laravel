@extends('layouts.base')
@section('title', trans('messages.home'))
@section('app')


    @push('styles')
        <style>
            :root {
                --minecraft-green: #4CAF50;
                --minecraft-brown: #8B4513;
                --minecraft-orange: #FF8C00;
                --minecraft-dark: #2C3E50;
                --minecraft-light: #ECF0F1;
            }

            body {
                min-height: 100vh;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                transition: background 0.3s, color 0.3s;
                background-color: #f0f0f0;
            }

            .main-container {
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                margin: 2rem auto;
                max-width: 950px;
                transition: background 0.3s, color 0.3s;
            }

            .header-section {
                background: linear-gradient(135deg, var(--minecraft-orange), #FF6B35);
                color: white;
                padding: 2rem;
                border-radius: 20px 20px 0 0;
                text-align: center;
                position: relative;
                /* Needed for positioning the toggle button */
            }

            .theme-toggle-btn {
                position: absolute;
                top: 1rem;
                right: 1rem;
                background: rgba(255, 255, 255, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.3);
                color: white;
                padding: 0.5rem 0.75rem;
                border-radius: 10px;
                cursor: pointer;
                transition: background 0.3s ease;
            }

            .theme-toggle-btn:hover {
                background: rgba(255, 255, 255, 0.3);
            }

            .section-card {
                border-radius: 15px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
                margin-bottom: 1.5rem;
                padding: 2rem;
                transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s, color 0.3s;
            }

            .section-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            }

            .section-card-header {
                background: linear-gradient(135deg, var(--minecraft-green), #45a049);
                color: white;
                padding: 1.2rem;
                border-radius: 15px 15px 0 0;
                border: none;
                margin: -2rem -2rem 1.5rem -2rem;
                /* Negative margin to pull it into the card */
                font-size: 1.4rem;
                font-weight: 600;
            }

            .accordion-button:not(.collapsed) {
                color: var(--minecraft-green);
            }

            .accordion-item {
                border: none;
                border-radius: 15px;
                margin-bottom: 1rem;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            }

            .accordion-item:hover {
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            }

            .accordion-button:focus {
                box-shadow: none;
            }

            /* DARK MODE STYLES */
            [data-bs-theme="dark"] {
                background-color: #1e1e2f;
                color: #e5e5e5;
            }

            [data-bs-theme="dark"] .main-container {
                background: #2a2a3a;
            }

            [data-bs-theme="dark"] .section-card {
                background: #333344;
                color: #f1f1f1;
            }

            [data-bs-theme="dark"] .accordion-item {
                background-color: #333344;
                border: 1px solid #4a4a58;
            }

            [data-bs-theme="dark"] .accordion-body {
                background-color: #3d3d4e;
                color: #e5e5e5;
            }

            [data-bs-theme="dark"] .accordion-button {
                color: #e5e5e5;
            }

            [data-bs-theme="dark"] .accordion-button:not(.collapsed) {
                color: var(--minecraft-orange);
                background-color: #3d3d4e;
            }
        </style>
    @endpush


    <div class="container my-5">
        <div class="main-container">
            <div class="header-section">
                <h1><i class="fas fa-question-circle me-3"></i>Help / FAQ</h1>
                <p class="lead mb-0">Find answers to the most common questions</p>
            </div>

            <div class="p-4 border-top border-2">
                <p class="lead">Here is a list of our most frequently asked questions. If you can't find your answer here,
                    please contact us!</p>
            </div>

            <div class="p-4">
                <div class="accordion accordion-flush" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                <i class="fas fa-question-circle me-3"></i>What is {{ site_name() }}?
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>This is a community server listing where you can find the best Minecraft servers to play
                                    online.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                <i class="fas fa-question-circle me-3"></i>How can I add my server?
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>You have to register and log in to add your server to the list.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree" aria-expanded="false"
                                aria-controls="flush-collapseThree">
                                <i class="fas fa-question-circle me-3"></i>How can I vote for my favorite server?
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>There is a 'vote' button next to the server info on each server page. Click on it to vote
                                    and support your favorite server!</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseFour" aria-expanded="false"
                                aria-controls="flush-collapseFour">
                                <i class="fas fa-question-circle me-3"></i>How can I get Minecraft?
                            </button>
                        </h2>
                        <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>You can purchase and download the game from the official website: <a
                                        href="https://www.minecraft.net" target="_blank">https://www.minecraft.net</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
