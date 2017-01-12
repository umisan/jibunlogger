<?php

/* main.html */
class __TwigTemplate_d3448883732fcf7375393157f12aa757f3d74f9ee722ed10fd649a628cdd28a7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"jp\">
<head>
    <title>自分ロガー</title>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <link rel=\"stylesheet\" href=\"./css/bootstrap.min.css\" type=\"text/css\">
    <script src=\"./js/jquery-3.1.1.min.js\"></script>
    <script src=\"./js/bootstrap.min.js\"></script>
</head>
<body>

<div class=\"container\">
    <h1>自分ロガー</h1>
    <p>毎日の生活をきろくしよう</p>
</div>
<div class=\"container\">
    <div class=\"form-group\">
        <label for=\"usrInput\">入力</label>
        <input type=\"text\" class=\"form-control\" id=\"usrInput\">
    </div>
</div>
<div class=\"container\">
    <ul class=\"nav nav-tabs\">
        <li class=\"active\"><a href=\"#\">日</a> </li>
        <li><a href=\"#\">週</a> </li>
        <li><a href=\"#\">月</a> </li>
        <li><a href=\"#\">年</a> </li>
    </ul>
</div>
<div class=\"container\">
</div>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "main.html";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "main.html", "C:\\xampp\\htdocs\\jibunlogger\\main.html");
    }
}
