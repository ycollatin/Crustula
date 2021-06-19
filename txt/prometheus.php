<?php
$titre = 'PROMETHEVS';
$data = array(
  array(
     'lat' => array('homines','antea','ab immortalibus','ignem','petebant'),
     //                0         1            2             3         4
     'fr'  => array('Avant','les hommes','demandaient','le feu','aux immortels'),
     //                0         1           2              3         4
     'ord' => array(1,0,4,3,2),
     'cas' => array(0=>'N',2=>'Ab',3=>'Ac')
  ),
  array( 
     'lat' => array('neque','in perpetuum','seruare','sciebant'), 
     'fr'  => array('et ne', 'savaient','le garder','pour toujours'),
     'ord' => array('0',3,2,1),
     'cas' => array(1=>'Ac')
  ),
  array( 
      'lat' => array('quod','postea','Prometheus','in ferula','detulit','in terras'),
      'fr'  => array('plus tard','Prométhée','le','fit descendre','sur les terres','dans une tige'),
      'ord' => array(2,0,1,5,3,4),
      'cas' => array(2=>'N',3=>'Ab',5=>'Ac')
  ),
  array( 
      'lat' => array('hominibus-','que','monstrauit','quomodo','cinere','obrutum','seruarent'),
      'fr'  => array('et','montra','aux hommes','comment','ils pouvaient le garder','recouvert','par la cendre'),
      'ord' => array(2,0,1,3,6,5,4),
      'cas' => array(0=>'D',4=>'Ab',5=>'Ac')
  ),
  array(
      'lat' => array('ob hanc rem','Mercurius','Iouis','iussu','deligauit','eum','in monte Caucaso',
                     'ad saxum','clauis ferreis'),
      'fr'  => array('Pour cette raison','Mercure','sur l\'ordre','de Jupiter','l\'','attacha',
                     'à un rocher','sur le mont Caucase','avec des liens de fer'), 
      'ord' => array(0,1,3,2,5,4,7,6,8),
      'cas' => array(0=>'Ac',1=>'N',2=>'G',3=>'Ab',5=>'Ac',6=>'Ab',7=>'Ac',8=>'Ab')
  ),
  array( 
      'lat' => array('et','aquilam','apposuit','quae','cor eius','exesset'),
      'fr'  => array('et','mit près de lui','un aigle','qui','devait manger','son coeur'),
      'ord' => array(0,2,1,3,5,4),
      'cas' => array(1=>'Ac',3=>'N',4=>'Ac')
  ),
  array(
      'lat' => array('quantum','die','ederat', 'tantum','nocte','crescebat'), 
      'fr'  => array('Tout ce qu\'','il avait mangé','le jour','repoussait','la nuit','en quantité égale'),
      'ord' => array(0,2,1,5,4,3),
      'cas' => array(1=>'Ab',4=>'Ab')
  ),
  array(
      'lat' => array('hanc aquilam','post xxx annos','Hercules','interfecit'),
      'fr'  => array('Hercule','trente ans après','tua','cet aigle'),
      'ord' => array(3,1,0,2),
      'cas' => array(0=>'Ac',1=>'Ac',2=>'N')
  ),
  array( 
      'lat' => array('eumque','liberauit'),
      'fr'  => array('et le','libéra'),
      'ord' => array(0,1),
      'cas' => array(0=>'Ac')
  ),
);
?>
