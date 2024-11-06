<?php
// Defina o diretório onde estão os arquivos CSV
$diretorio = 'C:/Users/edyelgue.carneiro/Downloads';

// Busca todos os arquivos .csv do diretório
$arquivosCsv = glob($diretorio . '/*.csv');

// Nome do arquivo final concatenado
$arquivoConcatenado = 'concatenado.csv';

// Abre o arquivo final em modo de escrita
$saida = fopen($arquivoConcatenado, 'w');

// Variável para controlar se o cabeçalho já foi adicionado
$cabecalhoAdicionado = false;

foreach ($arquivosCsv as $arquivo) {
    // Verifica se o arquivo existe e é legível
    if (is_readable($arquivo)) {
        // Abre o arquivo CSV em modo de leitura
        $entrada = fopen($arquivo, 'r');

        // Pega o cabeçalho (primeira linha) do arquivo
        $cabecalho = fgetcsv($entrada);

        // Escreve o cabeçalho apenas uma vez
        if (!$cabecalhoAdicionado && $cabecalho !== false) {
            fputcsv($saida, $cabecalho);
            $cabecalhoAdicionado = true;
        }

        // Lê e escreve cada linha do CSV no arquivo final
        while (($linha = fgetcsv($entrada)) !== false) {
            fputcsv($saida, $linha);
        }

        // Fecha o arquivo atual
        fclose($entrada);
    } else {
        echo "O arquivo $arquivo não pode ser lido.\n";
    }
}

// Fecha o arquivo final
fclose($saida);

echo "Concatenado com sucesso em $arquivoConcatenado.\n";
