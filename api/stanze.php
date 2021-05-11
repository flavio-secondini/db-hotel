<?php
  include_once __DIR__.'/../db.php'; //richiamo il database a cui mi sono collegato in db.php attraverso mysqli

  header('Content-type: application/json'); //devo definire i dati come file json per consentirne il richiamo da parte di vuejs (sezione "mounted")

  if (!empty($_GET) && $_GET['id']) { //se l'utente richiede un valore "id" specifico, eseguo le seguenti funzioni
    $id = $_GET['id']; //creo una variabile che lo contenga per comodità di scrittura
    $result = []; //definisco un array vuoto che andrò a riempire con i dati ottenuti

    $stmt = $conn->prepare("SELECT * FROM stanze WHERE id = ?"); //questo passaggio non serve per il richiamo dei dati ma per prevenire una sql injection
    $stmt->bind_param("i", $id); //dopo aver usato il "?" come placeholder per il vero valore, lo sostituisco con la funzione bind_param, grazie alla quale inserisco in modo sicuro il valore "$_GET['id'] fornito dall'utente per poi inviare la richiesta al database"

    $stmt->execute(); //eseguo la richiesta con i parametri forniti
    $rows = $stmt->get_result(); //salvo quello che ottengo in una variabile

    while($row = $rows->fetch_assoc()) { //creo un ciclo che riempia ogni riga della tabella con le informazioni richieste. Continuerà finchè
      $result[] = $row; //inserisco tutti i dati ottenuti nell'array definito inizialmente
    }

    echo json_encode([ //codifica json
      "response" => $result, //definisco il nome che avrà l'array di dati nel richiamo da vuejs
      "success" => true, //dichiaro il corretto passaggio di informazioni per vuejs
    ]);

  } else { //se l'utente non specifica alcun valore, eseguo le seguenti funzione
    $sql = "SELECT * FROM stanze"; //specifico la mia richiesta
    $rows = $conn->query($sql); //raggruppo i risultati in una variabile

    $result = []; //array vuoto da riempire con ogni riga ottenuta da un ciclo

    if ($rows && $rows->num_rows > 0) {
      while($row = $rows->fetch_assoc()) { //creo un ciclo che riempia ogni riga della tabella con le informazioni richieste. Continuerà finchè
        $result[] = $row; //inserisco tutti i dati ottenuti nell'array definito inizialmente
      }
    }

    echo json_encode([ //codifica json
      "response" => $result, //definisco il nome che avrà l'array di dati nel richiamo da vuejs
      "success" => true, //dichiaro il corretto passaggio di informazioni per vuejs
    ]);
  }
?>
