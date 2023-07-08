<?php

// Ignora warnings ao converter tags não reconhecidas 
// pela lib de XML interna do PHP
libxml_use_internal_errors(true); 

// Define URL alvo
$URL = 'https://www.imdb.com/chart/top';

// Faz a requisição GET para a página
$html_content = file_get_contents($URL);
if ($html_content === false) {
    echo "Falha ao carregar o conteúdo HTML.";
    exit;
}

$dom = new DOMDocument();
$dom->loadHTML($html_content);
$finder = new DomXPath($dom);

$main_title = $dom->getElementsByTagName('title')[0]->textContent;
echo '=====================================================' . "\n";
echo 'Scraping para página {' . $main_title . '}...' . "\n";
echo '=====================================================' . "\n";

// Obtém lista geral onde contém informações dos filmes
$moviesList = $finder->query('//ul[contains(@class, "ipc-metadata-list")]');

// Percorre cada uma das linhas da lista de filme
foreach ($moviesList as $rowList) {
    // Armazena as informações dos itens em $movies
    $movies = $rowList->getElementsByTagName('li');
    foreach ($movies as $movie) {
        $titleNode = $movie->getElementsByTagName('h3')[0]->textContent;
        echo $titleNode . "\n";
    }
}
