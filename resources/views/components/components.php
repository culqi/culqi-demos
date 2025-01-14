<?php
function renderLoader($show = false)
{
    if (!$show) return '';

    return "
    <div class='overlay-class'>
        <div class='spinner-container'>
            <div class='spinner-content'>
                <img src='./images/culqiLogo-animation.svg' alt='Logo animado' />
            </div>
        </div>
    </div>
    ";
}