<?php
// Solicita ao usuário o diretório onde estão os arquivos CSV
echo "Digite o caminho do diretório onde estão os arquivos CSV: ";
$diretorioEntrada = readline();

// Verifica se o diretório de entrada existe e é válido
if (!is_dir($diretorioEntrada)) {
    die("O diretório especificado para os arquivos CSV não existe ou não é válido.\n");
}

// Solicita ao usuário o diretório onde o arquivo consolidado será salvo
echo "Digite o caminho do diretório onde o arquivo consolidado será salvo: ";
$diretorioSaida = readline();

// Verifica se o diretório de saída existe e é válido
if (!is_dir($diretorioSaida)) {
    die("O diretório especificado para o arquivo consolidado não existe ou não é válido.\n");
}

// Busca todos os arquivos .csv do diretório de entrada
$arquivosCsv = glob($diretorioEntrada . '/*.csv');

// Verifica se há arquivos CSV no diretório de entrada
if (empty($arquivosCsv)) {
    die("Nenhum arquivo CSV encontrado no diretório especificado.\n");
}

// Define o caminho completo do arquivo final concatenado
$arquivoConcatenado = $diretorioSaida . '/concatenado.csv';

// Abre o arquivo final em modo de escrita
$saida = fopen($arquivoConcatenado, 'w');

// Variável para controlar se o cabeçalho já foi adicionado
$cabecalhoAdicionado = false;

foreach ($arquivosCsv as $arquivo) {
    // Verifica se o arquivo é legível
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
