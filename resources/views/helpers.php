<?php
require __DIR__ . '/components/components.php';

function renderView($view, $data = [])
{
  extract($data);
  ob_start();
  include __DIR__ . "/$view.php";
  $content = ob_get_clean();
  include __DIR__ . "/layouts/layout.php";
}

function renderError($code)
{
  http_response_code($code);
  renderView("errors/$code");
}

function renderViewEmpty($view, $data = [])
{
  extract($data);
  ob_start();
  include __DIR__ . "/$view.php";
  $content = ob_get_clean();
  include __DIR__ . "/layouts.empty.php";
}