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
  .vis-tooltip{
    max-width: 250px;
    white-space: normal !important;
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
      shape: "circularImage",
      title: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
    },
    <?php foreach ($vinculos as $vinculo) : ?> {
        id: <?php echo $vinculo->pessoa_vinculo_id  ?>,
        label: "<?php echo $vinculo->vinculo->pessoa_vinculo_nome ?>",
        image: "<?php echo $vinculo->vinculo->pessoa_imagem ? site_url('img/user/' .  $vinculo->vinculo->pessoa_imagem) : site_url('img/user/sem_imagem.png') ?>",
        shape: "circularImage",
        title: "<?php echo $vinculo->vinculo->pessoa_vinculo_nome ?>"
      },
    <?php endforeach; ?>

    <?php foreach ($veiculos as $veiculo) : ?> {
        id: <?php echo $veiculo->id . hexdec(substr(md5($veiculo->placa), 0, 8));  ?>, //gera um valor em hexadecimal a partir do md5 da placa
        label: "<?php echo $veiculo->placa ?>",
        image: "<?php echo site_url('img/user/car.png') ?>",
        shape: "circularImage",
        title: "<?php echo $veiculo->placa ?>"
      },
    <?php endforeach; ?>
  ]);

  // create an array with edges
  var edges = new vis.DataSet([
    <?php foreach ($vinculos as $vinculo) : ?> {
        from: <?php echo $vinculo->pessoa_id ?>,
        to: <?php echo $vinculo->pessoa_vinculo_id ?>,
        label: "<?php echo $vinculo->vinculo_nome ?>",
       
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
    interaction: {
      tooltipDelay: 300
    }
  };

  var network = new vis.Network(container, data, options);
</script>