<?php
// inc/security.php

/**
 * Sanitiza os dados para evitar injeção de código.
 *
 * @param mixed $data Dados a serem sanitizados.
 * @return mixed Dados sanitizados.
 */
function sanitizeData($data) {
    return htmlspecialchars(strip_tags($data));
}
