import pandas as pd
import os

# Diretório onde os arquivos Excel estão localizados
diretorio = "C:/Users/edyelgue.carneiro/Downloads"

# Lista para armazenar os DataFrames de cada arquivo
dataframes = []

# Loop por todos os arquivos no diretório
for arquivo in os.listdir(diretorio):
    if arquivo.endswith('.xlsx') or arquivo.endswith('.xls'):
        # Ler o arquivo Excel e adicionar ao DataFrame
        caminho_arquivo = os.path.join(diretorio, arquivo)
        df = pd.read_excel(caminho_arquivo)
        dataframes.append(df)

# Concatenar todos os DataFrames em um só
df_unido = pd.concat(dataframes, ignore_index=True)

# Salvar o DataFrame unido em um novo arquivo Excel
df_unido.to_excel('consolidado2024.xlsx', index=False)
