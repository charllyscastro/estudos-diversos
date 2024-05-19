<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vis</title>
  <link rel="stylesheet" type="text/css" href="https://unpkg.com/vis-network/dist/dist/vis-network.min.css" />
</head>

<style>
  /* #mynetwork {
    width: 100%;
    height: 100vh;
  } */

  body,
  select {
    font: 10pt sans;
  }

  #mynetwork {
    position: relative;
    width: 800px;
    height: 600px;
    border: 1px solid lightgray;
  }

  table.legend_table {
    font-size: 11px;
    border-width: 1px;
    border-color: #d3d3d3;
    border-style: solid;
  }

  table.legend_table,
  td {
    border-width: 1px;
    border-color: #d3d3d3;
    border-style: solid;
    padding: 2px;
  }

  div.table_content {
    width: 80px;
    text-align: center;
  }

  div.table_description {
    width: 100px;
  }

  #operation {
    font-size: 28px;
  }

  #node-popUp {
    display: none;
    position: absolute;
    top: 350px;
    left: 170px;
    z-index: 299;
    width: 250px;
    height: 120px;
    background-color: #f9f9f9;
    border-style: solid;
    border-width: 3px;
    border-color: #5394ed;
    padding: 10px;
    text-align: center;
  }

  #edge-popUp {
    display: none;
    position: absolute;
    top: 350px;
    left: 170px;
    z-index: 299;
    width: 250px;
    height: 90px;
    background-color: #f9f9f9;
    border-style: solid;
    border-width: 3px;
    border-color: #5394ed;
    padding: 10px;
    text-align: center;
  }
</style>

<body>
  <p>Vis</p>


  <div id="mynetwork"></div>

  <script type="text/javascript" src="https://unpkg.com/vis-network/dist/vis-network.min.js"></script>
</body>

</html>

<script type="text/javascript">

  // create a network
  var nodes = new vis.DataSet([{
      id: <?php echo $pessoa->id ?>,
      label: "<?php echo $pessoa->nome ?>",
      image: "<?php echo site_url('img/user/' . $pessoa->imagem) ?>",
      shape: "circularImage"
    },
    <?php foreach ($vinculos as $vinculo) : ?> {
        id: <?php echo $vinculo->pessoa_vinculo_id  ?>,
        label: "<?php echo $vinculo->vinculo->pessoa_vinculo_nome ?>",
        image: "<?php echo $vinculo->vinculo->pessoa_imagem ? site_url('img/user/' .  $vinculo->vinculo->pessoa_imagem) : site_url('img/user/sem_imagem.png') ?>",
        shape: "circularImage"
      },
    <?php endforeach; ?>

    <?php foreach ($veiculos as $veiculo) : ?> {
        id: <?php echo $veiculo->id . hexdec(substr(md5($veiculo->placa), 0, 8));  ?>, //gera um valor em hexadecimal a partir do md5 da placa
        label: "<?php echo $veiculo->placa ?>",
        image: "<?php echo site_url('img/user/car.png') ?>",
        shape: "circularImage"
      },
    <?php endforeach; ?>
  ]);

  // create an array with edges
  var edges = new vis.DataSet([
    <?php foreach ($vinculos as $vinculo) : ?> {
        from: <?php echo $vinculo->pessoa_id ?>,
        to: <?php echo $vinculo->pessoa_vinculo_id ?>,
        label: "<?php echo $vinculo->vinculo_nome ?>"
      },
    <?php endforeach; ?>

    <?php foreach ($veiculos as $veiculo) : ?> {
        from: <?php echo $veiculo->pessoa_id ?>,
        to: <?php echo $veiculo->id . hexdec(substr(md5($veiculo->placa), 0, 8)) ?>,
        label: "veiculo"
      },
    <?php endforeach; ?>

  ]);

  var container = document.getElementById("mynetwork");

  var data = {
    nodes: nodes,
    edges: edges
  };
  
  var options = {
    manipulation: {
      enabled: true,
      addNode: false,
      addEdge: false,
      deleteNode: true

    },
  };

  var network = new vis.Network(container, data, options);
</script>