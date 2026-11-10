<?php

date_default_timezone_set('America/Sao_Paulo');
$quadras = [
  1 => ['imagem'=>'img/sintetico.jpeg', 'alt'=>'Quadra coberta de grama sintética', 'nome'=>'Arena Society', 'modalidade'=>'Futebol', 'piso'=>'Grama sintética', 'preco'=>120, 'capacidade'=>'14 jogadores', 'cobertura'=>'Coberta', 'descricao'=>'Espaço para reunir o time e jogar futebol society, com iluminação para partidas à noite.'],
  2 => ['imagem'=>'img/salao.jpg', 'alt'=>'Quadra poliesportiva coberta', 'nome'=>'Quadra Central', 'modalidade'=>'Futsal', 'piso'=>'Piso esportivo', 'preco'=>90, 'capacidade'=>'10 jogadores', 'cobertura'=>'Coberta', 'descricao'=>'Quadra coberta para partidas de futsal, com marcação completa e proteção lateral.'],
  3 => ['imagem'=>'img/areia.jpg', 'alt'=>'Quadra coberta de areia com rede', 'nome'=>'Arena de Areia', 'modalidade'=>'Vôlei de praia', 'piso'=>'Areia', 'preco'=>70, 'capacidade'=>'4 jogadores', 'cobertura'=>'Coberta', 'descricao'=>'Quadra de areia com rede para vôlei de praia, ideal para uma partida entre amigos.']
];
function e($valor) { return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8'); }
function preco($valor) { return 'R$ '.number_format($valor, 2, ',', '.'); }
