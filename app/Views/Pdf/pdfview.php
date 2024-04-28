<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor CKEditor</title>
    <link rel="stylesheet" href="<?php echo base_url('trumbowyg/dist/ui/trumbowyg.min.css') ?> ">
    <link rel="stylesheet" href="<?php echo base_url('trumbowyg/dist/plugins/emoji/ui/trumbowyg.emoji.min.css') ?>">
    <style>
        .relatorio-container {
            max-width: 2400px;
            margin: 20px auto 10px auto;
            padding: 10px;
        }

        .relatorio-text1,
        .relatorio-text2 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;

        }

        .relatorio-text2 {
            border: 1px solid #ccc;
        }

        .relatorio-text1 {
            color: red;
            letter-spacing: .2rem;
        }

        .relatorio-tabela {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            width: 140px;
        }
    </style>
</head>

<body>
   
        <?php echo $artigo ?>

</body>

</html>