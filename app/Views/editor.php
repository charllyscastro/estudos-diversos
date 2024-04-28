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
    <form action="<?= site_url('editor/saveContent') ?>" method="post">
        <label>Título:</label><br>
        <input type="text" name="titulo"><br><br>
        <div class="relatorio-container" name="conteudo" id="conteudo" rows="5">
            <div id="editor">
                <div class="non-editable">
                    <h1 class="relatorio-text1" contenteditable="false">RELATÓRIO</h1>
                    <h2 class="relatorio-text2" contenteditable="false">Relatório</h2>
                    <table class="relatorio-tabela">
                        <tr>
                            <th class="relatorio-cabecalho" contenteditable="false">DATA</th>
                            <td class="relatorio-data" contenteditable="false"><?php echo mb_strtoupper(data()); ?></td>
                        </tr>
                        <tr>
                            <th class="relatorio-cabecalho"  contenteditable="false">ASSUNTO</th>
                            <td class="relatorio-data">ASSUNTO...</td>
                        </tr>
                        <tr>
                            <th class="relatorio-cabecalho" contenteditable="false">ORIGEM</th>
                            <td class="relatorio-data">ORIGEM...</td>
                        </tr>
                        <tr>
                            <th class="relatorio-cabecalho" contenteditable="false">DIFUSÃO</th>
                            <td class="relatorio-data">DIFUSÃO</td>
                        </tr>
                        <tr>
                            <th class="relatorio-cabecalho" contenteditable="false">DIF. ANT.</th>
                            <td class="relatorio-data">*.*.*.</td>
                        </tr>
                        <tr>
                            <th class="relatorio-cabecalho" contenteditable="false">REF</th>
                            <td class="relatorio-data">*.*.*.</td>
                        </tr>
                        <tr>
                            <th class="relatorio-cabecalho" contenteditable="false">ANEXO(S)</th>
                            <td class="relatorio-data">*.*.*.</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <input type="submit" value="Salvar">
    </form>

    <hr>
    <h3>Artigos</h3>

    <?php if (empty($artigos)) : ?>
        <p>não existem artigos cadastrados</p>
    <?php else : ?>
        <?php foreach ($artigos as $artigo) : ?>
            <h2><?php echo $artigo->titulo ?></h2>
            <p><?php echo $artigo->conteudo ?></p>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')
    </script>
    <script src="//rawcdn.githack.com/RickStrahl/jquery-resizable/0.35/dist/jquery-resizable.min.js"></script>
    <script src="<?php echo base_url('trumbowyg/dist/trumbowyg.min.js') ?> "></script>

    <!-- Plugin para linguagem -->
    <script type="text/javascript" src="<?php echo base_url('trumbowyg/dist/langs/pt_br.min.js') ?>"></script>

    <!-- Plugin para Emoji -->
    <script type="text/javascript" src="<?php echo base_url('trumbowyg/dist/plugins/emoji/trumbowyg.emoji.min.js') ?>"></script>

    <!-- Plugin para upload de imagem / precisa de um método na controller -->
    <script type="text/javascript" src="<?php echo base_url('trumbowyg/dist/plugins/upload/trumbowyg.upload.min.js') ?>"></script>

    <!-- Plugin para CTRL + C de imagem -->
    <script src="<?php echo base_url('trumbowyg/dist/plugins/pasteimage/trumbowyg.pasteimage.min.js') ?>"></script>

    <!-- Plugin para redimensionamento de imagem -->
    <script src="<?php echo base_url('trumbowyg/dist/plugins/resizimg/trumbowyg.resizimg.min.js') ?>"></script>
    <script>
    </script>

    <script>
        $(document).ready(function() {
            $('#conteudo').trumbowyg({
                lang: 'pt_br',
                btns: [
                    ['viewHTML'],
                    ['undo', 'redo'], // Only supported in Blink browsers
                    ['formatting'],
                    ['strong', 'em', 'del'],
                    ['superscript', 'subscript'],
                    ['link'],
                    ['insertImage'],
                    ['upload'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                    ['unorderedList', 'orderedList'],
                    ['horizontalRule'],
                    ['removeformat'],
                    ['emoji'],
                    ['fullscreen'],
                ],
                plugins: {
                    // Add imagur parameters to upload plugin for demo purposes
                    upload: {
                        serverPath: "<?php echo site_url('editor/loadImage') ?>",
                        fileFieldName: 'image',
                        headers: {
                            'Authorization': 'Client-ID xxxxxxxxxxxx'
                        },
                        urlPropertyName: 'file'
                    },
                    resizimg: {
                        minSize: 64,
                        step: 16,
                    },
                },
                autogrow: true,
            });
            // Impede a edição do texto nos elementos com a classe 'non-editable'
            $('#editor .non-editable').on('keydown paste', function(event) {
                event.preventDefault();
            });

        });
    </script>
</body>

</html>