<?php

// This file is generated by Composer
require_once '../vendor/autoload.php';

use \Databox\DataboxClient;
use \Databox\DataboxClientBuilder;
use \Databox\DataboxException;
use \Databox\DataboxBuilder;
use \Guzzle\Common\Exception\RuntimeException;
use \Exception;
use \Databox\Widget as Widget;
use \Databox\Widget\Table as Table;
use \Databox\KPI as KPI;

//Instantiate the client
$client = new DataboxClient('https://dev.databox.com/');
$client->setApiKey('1znxuvbjrqe8c8k44w848o0owowsgk8c');
$client->setUniqueUrl('34s0v2pdlmg44wwc');
//The client builder extends Guzzle Client, so you can add Guzzle compatible event subscribers and plugins to it if you like

//Instantiate the builder
$builder = new DataboxBuilder();

//The addKpi method uses the accepts $key, $value, $date (in that order). Date should be a timestamp in the format Y-m-d\TH:i:s. Date may be NULL, in which case the current UTC time will be used.
$builder->addKpi(new KPI("testmain", mt_rand(1,600)));
$builder->addKpi(new KPI("testbignumber", mt_rand(1,600)));
$builder->addKpi(new KPI("testcompare", mt_rand(1,600)));
$builder->addKpi(new KPI("testcompare", mt_rand(1,600)));
$builder->addKpi(new KPI("testintervalvalues", mt_rand(1,600)));
$builder->addKpi(new KPI("testlinechart", mt_rand(1,600)));
$builder->addKpi(new KPI("testbarchart", mt_rand(1,600)));

$table = new Widget\Table("testtable");
$table->addColumn("KPI", "string");
$table->addColumn("Today", "float");
$table->addColumn("Yesterday", "float");
$table->addRow(new Table\ColumnData("Visitors"), new Table\ColumnData(1234, 567), new Table\ColumnData(9876, 123));
$builder->addWidget($table);

$progress = new Widget\Progress("testprogress");
$progress->setMax(123);
$progress->setLabel("Life achievements");
$progress->setValue(10);
$builder->addWidget($progress);

$messages = new Widget\Messages("testmessages");
$messages->addMessage("I like pie!");
$messages->addMessage("Sweden");
$builder->addWidget($messages);

$pie = new Widget\Pie("testpie");
$pie->addSlice("Pepperoni", 20);
$pie->addSlice("Salami", 50, -10);
$pie->addSlice("Tuna", 70, -30);
$builder->addWidget($pie);

$pie = new Widget\Funnel("testfunnel");
$pie->addSlice("Cheese", 5);
$pie->addSlice("Meat", 90, -10);
$pie->addSlice("Apples", 10, -30);
$builder->addWidget($pie);

$pie = new Widget\Pipeline("testpipeline");
$pie->addSlice("Mac", 20, 24);
$pie->addSlice("PC", 30, -10);
$pie->addSlice("Amiga", 10, -10);
$builder->addWidget($pie);

//You must provide uniqueURL and payload parameters. Payload can be any JSON string, but we reccommend you use our builder class.
try {
    //If no Exception is raised everything went through as it should've :)
    $returnedResult = $client->pushData($builder);
    echo $returnedResult;
} catch (DataboxException $e) {
    echo $e->getType();
    echo $e->getWebMessage();
    echo $e->getMessage();
} catch (RuntimeException $e) {
    echo $e->getMessage();
    echo $e->getCode();
} catch (Exception $e) {
    echo $e->getMessage();
} 

//Fetch the saved data log
$log = $client->getPushLog();

echo $log;