<?php

    /* =============================================
        functions
    ============================================= */

function renderExample($output)
{
    $html = '';
    $nbre = count($output['form']);
    for ($i = 0; $i < $nbre; $i++) {
        $nb_text      = '';
        if ($nbre > 1) {
            $nb_text = ' ' . ($i + 1);
        }
        $title = '';
        if (!empty($output['title'][$i])) {
            $title = ' - ' . $output['title'][$i];
        }
        $html .= '<div class="mb-6">';
        $html .= '<p class="h4">Example' . $nb_text . $title . '</p>' . " \n";
        $html .= '<div class="form-code"><pre class="line-numbers language-php"><code class="language-php">' . $output['form_code'][$i] . '</code></pre></div>' . " \n";
        $form = $output['form'][$i];
        if (is_object($form)) {
            $html .= '<div class="output pt-5">' . " \n";

            // if modal or popover
            if ($form->form_ID == 'plugins-modal-form-1') {
                $html .= '<div class="text-center"> <a data-remodal-target="modal-target" class="btn btn-primary text-white btn-lg">Sign Up</a> </div>';
            } elseif ($form->form_ID == 'plugins-popover-form-1') {
                $html .= '<div class="text-center"> <a href="#" id="popover-link" class="btn btn-primary text-white btn-lg">Sign Up</a> </div>';
            }

            $html .= $form->render(false, false);

            $html .= '</div>';
        } else {
            $html .= '<div class="output pt-5">' . $form . '</div>';
        }
        $uniqid = uniqid();
        $html .= '<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="collapse" data-target="#' . $uniqid . '" aria-expanded="false" aria-controls="' . $uniqid . '">show output code</button>' . " \n";
        $html .= '<div class="output-code collapse" id="' . $uniqid . '"><pre class="line-numbers language-php"><code class=" language-php">' . $output['html_code'][$i] . '</code></pre></div>' . " \n";
        $html .= '</div>';

        if (is_object($form)) {
            $form->setMode('development');
            $form->useLoadJs();
            $jsfiles  = preg_replace("/\r|\n/", "", $form->printIncludes('js', false, false));

            $html .= $jsfiles;
            $html .= $form->printJsCode(false, false);
        }
    }

    return $html;
}
