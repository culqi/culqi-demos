<?php

function renderInput($type, $id, $label, $placeholder, $value = '', $errors = [], $onblur = '', $onfocus = '')
{
    $errorClass = '';
    $errorMessage = "<p class='text-red-500 text-xs italic hidden' id='{$id}-error'>" . (isset($errors[$id]) ? $errors[$id] : '') . "</p>";

    return "
    <div class='mb-4'>
        <label class='block text-gray-700 text-sm font-bold mb-2' for='{$id}'>
            {$label}
        </label>
        <input
            class='shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline {$errorClass}'
            id='{$id}'
            type='{$type}'
            placeholder='{$placeholder}'
            value='{$value}'
            onblur='{$onblur}'
            onfocus='{$onfocus}'
        />
        {$errorMessage}
    </div>
    ";
}

function renderCard($title, $description, $link = null)
{
    return "<div class='bg-white p-6 rounded-lg shadow'>
                <h4 class='text-xl font-bold mb-2'>{$title}</h4>
                <p class='text-gray-600'>{$description}" . ($link ? " <a href='{$link}' target='_blank' class='text-blue-500 underline'>Ver documentación</a>." : "") . "</p>
            </div>";
}