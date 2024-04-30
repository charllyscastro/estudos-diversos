<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar pdf</title>
</head>
<body>

    <div>
        <h1>Gerar pdf com PHP - Codeigniter4</h1>
        <a href="<?php echo site_url('pdf-gerar')?>">Gerar pdf</a><br><br>
        <a href="<?php echo site_url('pdf-gerar-imagem')?>">Gerar pdf imagem</a><br><br>
        <a href="<?php echo site_url('pdf-gerar-css-externo')?>">Gerar pdf css externo</a><br><br>
        <a href="<?php echo site_url('pdf-gerar-relatorio-bd')?>">Gerar pdf relatório bd</a><br><br>

        <hr>
        <h3>Pesquisar</h3>
        <form method="post" action="<?php echo site_url('pdf-gerar-relatorio-filtro-bd')?>">
            <label>Pesquisar</label>
            <input type="text" name="texto_pesquisar" placeholder="Pesquisar pelo termo"><br><br>
            <input type="submit" value="Pesquisar"><br><br>
        </form>
        <br>
        <br>
        

    </div>
</body>
</html>