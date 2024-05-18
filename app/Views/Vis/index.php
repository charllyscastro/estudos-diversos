<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vis</title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/vis-network/dist/dist/vis-network.min.css" />
</head>

<style>
    #mynetwork{
        width: 100%;
        height: 100vh;
    }
</style>
<body>
    <p>Vis</p>

    <div id="mynetwork"></div>

    <script type="text/javascript" src="https://unpkg.com/vis-network/dist/vis-network.min.js"></script>
</body>
</html>

<script type="text/javascript">
 // create an array with nodes
  var nodes = new vis.DataSet([
    { id: <?php echo $pessoa->id ?>, label: "<?php echo $pessoa->nome ?>" },
    <?php foreach($vinculos as $vinculo): ?>
      { id: <?php echo $vinculo->pessoa_vinculo_id  ?>, label: "<?php echo $vinculo->vinculo->pessoa_vinculo_nome   ?>" },
    <?php endforeach; ?>
  ]);
  
  // create an array with edges
  var edges = new vis.DataSet([
    <?php foreach($vinculos as $vinculo): ?>
      { from: <?php echo $vinculo->pessoa_id ?>, to: <?php echo $vinculo->pessoa_vinculo_id ?>, label: "<?php echo $vinculo->vinculo_nome ?>", arrows: { to: { enabled: true, scaleFactor: 1, type: 'arrow' } } },
    <?php endforeach; ?>

  ]);

  // create a network
  var container = document.getElementById("mynetwork");
  var data = {
    nodes: nodes,
    edges: edges
  };
  var options = {

    edges: {
        arrows: {
          to: {
            enabled: true,
            scaleFactor: 1, // Pode ajustar o tamanho da seta conforme necessário
            type: 'arrow'
          }
        }
      }
  };
  var network = new vis.Network(container, data, options);









</script>