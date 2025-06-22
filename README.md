# ADAC

- Build da imagem do docker
  `$ sudo docker build -t adac .` 

- Obter ID da imagem
  `$ sudo docker images`

- Executar
  `$ sudo docker run -p <PORTA_LOCALHOST>:80 -d -v <PATH_REPOSITORIO_CLONADO>:/var/www/adac --name adac <ID_DA_IMAGEM>`

  Exemplo:
  `$ sudo docker run -p 8080:80 -d -v /home/caroline/Documentos/adac_docker:/var/www/adac --name adac 6608cedf42b6`

- URL do projeto após executar o Docker:
    *localhost:<PORTA>*

    Exemplo:
    *localhost:8080*
