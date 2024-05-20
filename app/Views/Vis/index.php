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
    width: 90%;
    height: 90vh;
    border: 1px solid lightgray;
  }

  .vis-tooltip {
    max-width: 250px;
    white-space: normal !important;
  }
</style>

<body>
  <p>Vis</p>


  <div id="mynetwork"></div>

  <script type="text/javascript" src="https://unpkg.com/vis-network/dist/vis-network.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</body>

</html>

<script type="text/javascript">
  // create a network

  var nodes = [];
  var edges = [];
  nodes = new vis.DataSet([{
      id: <?php echo $pessoa->id ?>,
      label: "<?php echo $pessoa->nome ?>",
      image: "<?php echo site_url('img/user/' . $pessoa->imagem) ?>",
      shape: "circularImage",
      title: "<?php echo $pessoa->nome ?>"
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
  edges = new vis.DataSet([
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
      initiallyActive: true,
      enabled: true,
      addNode: false,
      addEdge: false,
      deleteNode: true

    },
    interaction: {
      tooltipDelay: 300,
      navigationButtons: true,
    }
  };

  var network = new vis.Network(container, data, options);

  network.on("doubleClick", function(params) {
    // console.log(params.nodes[0]);
    $.ajax({
      url: "<?php echo site_url('visjs-get'); ?>",
      type: "GET",
      dataType: "json",
      data: {
        pessoa_id: params.nodes[0]
      },
      success: function(response) {

        if (response.vinculos) {
          response.vinculos.forEach(el => {
            if (!nodes.get(el.pessoa_vinculo_id)) {
            nodes.add({
              id: el.pessoa_vinculo_id,
              label: el.vinculo.pessoa_vinculo_nome,
              image: el.vinculo.pessoa_imagem ? "<?php echo site_url("img/user/") ?>" + el.vinculo.pessoa_imagem : "<?php echo site_url('img/user/sem_imagem.png') ?>",
              shape: "circularImage",
              title: el.vinculo.pessoa_vinculo_nome
            })
          }

            edges.add({
              from: el.pessoa_id,
              to: el.pessoa_vinculo_id,
              label: el.vinculo_nome,
            });
          });




        }
        // edges = [...edges, ]
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
        // Trate o erro conforme necessário
      }
    });
    // params.event = "[original event]";
    // document.getElementById("eventSpanHeading").innerText = "Click event:";
    // document.getElementById("eventSpanContent").innerText = JSON.stringify(
    //   params,
    //   null,
    //   4
    // );
    // console.log(
    //   "click event, getNodeAt returns: " + this.getNodeAt(params.pointer.DOM)
    // );
  });
</script>