<?php

class QuestionsEs extends Doctrine_Migration_Base
{
  public function up()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
UPDATE question SET question_es='termine la escuela.' WHERE ru_question_number=1;
UPDATE question SET question_es='me vaya bien en la escuela.' WHERE ru_question_number=2;
UPDATE question SET question_es='vaya a la universidad' WHERE ru_question_number=3;
UPDATE question SET question_es='me vaya bien en la universidad.' WHERE ru_question_number=4;
UPDATE question SET question_es='me asegure que mis maestros sepan que quiero que me vaya bien en la escuela.' WHERE ru_question_number=5;
UPDATE question SET question_es='investigue acerca de las universidades.' WHERE ru_question_number=6;
UPDATE question SET question_es='aprenda cómo tener éxito en la universidad.' WHERE ru_question_number=7;
UPDATE question SET question_es='saque buenas calificaciones en la escuela.' WHERE ru_question_number=8;
UPDATE question SET question_es='aprenda cómo tener éxito en la escuela.' WHERE ru_question_number=9;
UPDATE question SET question_es='obtenga un título universitario.' WHERE ru_question_number=10;
UPDATE question SET question_es='hacer nuevos amigos en la escuela.' WHERE ru_question_number=11;
UPDATE question SET question_es='hablar con los maestros acerca de las tareas.' WHERE ru_question_number=12;
UPDATE question SET question_es='tomar buenos apuntes en clase.' WHERE ru_question_number=13;
UPDATE question SET question_es='hacer trabajos para la clase de inglés.' WHERE ru_question_number=14;
UPDATE question SET question_es='tomar parte en actividades deportivas.' WHERE ru_question_number=15;
UPDATE question SET question_es='entender lo que lees en los libros escolares.' WHERE ru_question_number=16;
UPDATE question SET question_es='hacer preguntas en clase.' WHERE ru_question_number=17;
UPDATE question SET question_es='participar en un club después de la escuela.' WHERE ru_question_number=18;
UPDATE question SET question_es='resolver correctamente los problemas matemáticos.' WHERE ru_question_number=19;
UPDATE question SET question_es='entregar las tareas a tiempo.' WHERE ru_question_number=20;
UPDATE question SET question_es='ir a clases todos los días.' WHERE ru_question_number=21;
UPDATE question SET question_es='trabajar en proyectos en grupo.' WHERE ru_question_number=22;
UPDATE question SET question_es='llevarse bien con los compañeros de clase.' WHERE ru_question_number=23;
UPDATE question SET question_es='salir bien en las pruebas.' WHERE ru_question_number=24;
UPDATE question SET question_es='usar una computadora para hacer los trabajos.' WHERE ru_question_number=25;
UPDATE question SET question_es='usar los servicios en las bibliotecas.' WHERE ru_question_number=26;
UPDATE question SET question_es='usar la computadora para buscar información en Internet.' WHERE ru_question_number=27;
UPDATE question SET question_es='participar en discusiones de clase.' WHERE ru_question_number=28;
UPDATE question SET question_es='estar al día en cuanto a los trabajos escolares.' WHERE ru_question_number=29;
UPDATE question SET question_es='prepararse para hacer una prueba.' WHERE ru_question_number=30;
UPDATE question SET question_es='relajarse al hacer pruebas.' WHERE ru_question_number=31;
UPDATE question SET question_es='estudiar con tus compañeros para las pruebas.' WHERE ru_question_number=32;
UPDATE question SET question_es='Tengo un familiar con el que puedo hablar acerca de las decisiones importantes en mi vida.' WHERE ru_question_number=33;
UPDATE question SET question_es='Mis familiares reconocen mi capacidad y mis habilidades.' WHERE ru_question_number=34;
UPDATE question SET question_es='A nadie en mi familia le interesa lo mismo que a mí, ni mis preocupaciones.' WHERE ru_question_number=35;
UPDATE question SET question_es='Tengo una relación muy cercana por lo menos con unos de mis familiares.' WHERE ru_question_number=36;
UPDATE question SET question_es='No tengo ningún familiar al que le tenga confianza para hablar acerca de mis problemas.' WHERE ru_question_number=37;
UPDATE question SET question_es='Puedo hablar acerca de problemas escolares con un familiar.' WHERE ru_question_number=38;
UPDATE question SET question_es='Tengo familiares con los que puedo contar en caso de emergencia.' WHERE ru_question_number=39;
UPDATE question SET question_es='Aquí los maestros se preocupan por sus estudiantes.' WHERE ru_question_number=40;
UPDATE question SET question_es='Aquí hay un maestro con el que puedo hablar acerca de mis problemas académicos.' WHERE ru_question_number=41;
UPDATE question SET question_es='Aquí los maestros me respetan.' WHERE ru_question_number=42;
UPDATE question SET question_es='Aquí los maestros están interesados en mi éxito.' WHERE ru_question_number=43;
UPDATE question SET question_es='Aquí hay un maestro con el que puedo hablar acerca de mis problemas personales.' WHERE ru_question_number=44;
UPDATE question SET question_es='Aquí en la escuela tengo amigos.' WHERE ru_question_number=45;
UPDATE question SET question_es='Tengo amigos con los que pueda hablar acerca de decisiones importantes.' WHERE ru_question_number=46;
UPDATE question SET question_es='Tengo un amigo con el que puedo contar si necesito ayuda.' WHERE ru_question_number=47;
UPDATE question SET question_es='No tengo amigos en los que pueda confiar.' WHERE ru_question_number=48;
UPDATE question SET question_es='Tener dificultad para cumplir con las responsabilidades escolares y del hogar.' WHERE ru_question_number=49;
UPDATE question SET question_es='Tener dificultad al tratar de hacer amigos.' WHERE ru_question_number=50;
UPDATE question SET question_es='Tener dificultad al hacer pruebas.' WHERE ru_question_number=51;
UPDATE question SET question_es='Tener dificultad para hablar con los maestros acerca de los trabajos escolares.' WHERE ru_question_number=52;
UPDATE question SET question_es='Tener miedo por no poder cumplir con las expectativas familiares.' WHERE ru_question_number=53;
UPDATE question SET question_es='Tener dificultades para hacer preguntas en clase.' WHERE ru_question_number=54;
UPDATE question SET question_es='Tener dificultad para vivir en la comunidad local.' WHERE ru_question_number=55;
UPDATE question SET question_es='Tener dificultad para entender cómo usar la biblioteca escolar.' WHERE ru_question_number=56;
UPDATE question SET question_es='Tener dificultad para manejar tus relaciones personales.' WHERE ru_question_number=57;
UPDATE question SET question_es='Tener dificultad con la cantidad de trabajos escolares.' WHERE ru_question_number=58;
UPDATE question SET question_es='Tener dificultad porque tus compañeros de clase te tratan diferente a lo que ellos se tratan entre si.' WHERE ru_question_number=59;
UPDATE question SET question_es='Tener dificultad para hacer los trabajos escolares.' WHERE ru_question_number=60;
UPDATE question SET question_es='Tener dificultad para aprender a usar las computadoras.' WHERE ru_question_number=61;
UPDATE question SET question_es='Tener dificultad para pagar los útiles escolares.' WHERE ru_question_number=62;
UPDATE question SET question_es='Tener dificultades económicas porque le debes dinero a la gente.' WHERE ru_question_number=63;
UPDATE question SET question_es='Tener dificultad para pagar alimentos.' WHERE ru_question_number=64;
UPDATE question SET question_es='Tener dificultad para pagar por actividades recreativas y diversiones.' WHERE ru_question_number=65;
UPDATE question SET question_es='Tener dificultad porque tu familia tiene problemas de dinero.' WHERE ru_question_number=66;
UPDATE question SET question_es='Tener dificultad para hacer tu tarea a tiempo.' WHERE ru_question_number=67;
UPDATE question SET question_es='Tener dificultad por sentir la necesidad de salir bien en la escuela.' WHERE ru_question_number=68;
UPDATE question SET question_es='Tener dificultad con los maestros.' WHERE ru_question_number=69;
UPDATE question SET question_es='Tener dificultad con los compañeros.' WHERE ru_question_number=70;
UPDATE question SET question_es='Te sientes cansado pero no puedes dormir.' WHERE ru_question_number=71;
UPDATE question SET question_es='Tienes cambios de humor.' WHERE ru_question_number=72;
UPDATE question SET question_es='Sientes que estas en peligro.' WHERE ru_question_number=73;
UPDATE question SET question_es='Te sientes deprimido.' WHERE ru_question_number=74;
UPDATE question SET question_es='Te sientes inseguro.' WHERE ru_question_number=75;
UPDATE question SET question_es='Tienes pesadillas.' WHERE ru_question_number=76;
UPDATE question SET question_es='Comes entre las comidas más de lo normal.' WHERE ru_question_number=77;
UPDATE question SET question_es='Te sientes desanimado.' WHERE ru_question_number=78;
UPDATE question SET question_es='Duermes menos de lo normal por las noches.' WHERE ru_question_number=79;
UPDATE question SET question_es='Te sientes enfermo.' WHERE ru_question_number=80;
UPDATE question SET question_es='Comes demasiado.' WHERE ru_question_number=81;
UPDATE question SET question_es='Rompes cosas cuando estás enojado.' WHERE ru_question_number=82;
UPDATE question SET question_es='Te dan dolores de cabeza.' WHERE ru_question_number=83;
UPDATE question SET question_es='Te aumenta el latido del corazón.' WHERE ru_question_number=84;
UPDATE question SET question_es='Peleas con tus amigos.' WHERE ru_question_number=85;
UPDATE question SET question_es='Te sientes molesto.' WHERE ru_question_number=86;
UPDATE question SET question_es='Te enojas.' WHERE ru_question_number=87;
UPDATE question SET question_es='Te sientes nervioso.' WHERE ru_question_number=88;
UPDATE question SET question_es='No duermes bien.' WHERE ru_question_number=89;
UPDATE question SET question_es='Te sientes mal del estómago.' WHERE ru_question_number=90;
UPDATE question SET question_es='No puedes dormir.' WHERE ru_question_number=91;
UPDATE question SET question_es='Te aumenta el apetito.' WHERE ru_question_number=92;
UPDATE question SET question_es='Te molestas fácilmente.' WHERE ru_question_number=93;
UPDATE question SET question_es='porque de verdad me gusta la escuela.' WHERE ru_question_number=94;
UPDATE question SET question_es='porque si no viniera, me sentiría culpable.' WHERE ru_question_number=95;
UPDATE question SET question_es='que así podré ganar muchísimo dinero.' WHERE ru_question_number=96;
UPDATE question SET question_es='porque la educación es importante para lograr las metas que tengo.' WHERE ru_question_number=97;
UPDATE question SET question_es='que así no voy a decepcionar a las personas importantes en mi vida.' WHERE ru_question_number=98;
UPDATE question SET question_es='porque es divertido.' WHERE ru_question_number=99;
UPDATE question SET question_es='porque tengo que hacerlo, es un requisito.' WHERE ru_question_number=100;
UPDATE question SET question_es='porque no quiero defraudar a nadie.' WHERE ru_question_number=101;
UPDATE question SET question_es='porque aprender a leer, matemáticas y ciencias es importante para mí.' WHERE ru_question_number=102;
UPDATE question SET question_es='si no lo hago me castigan.' WHERE ru_question_number=103;
UPDATE question SET question_es='porque no me guastaría no obtener mi diploma o certificado y me decepcionaría.' WHERE ru_question_number=104;
UPDATE question SET question_es='porque hay muchas cosas interesantes que hacer.' WHERE ru_question_number=105;
UPDATE question SET question_es='porque me doy cuenta de la importancia que tiene aprender.' WHERE ru_question_number=106;
UPDATE question SET question_es='porque para mí la educación es importante.' WHERE ru_question_number=107;
UPDATE question SET question_es='No estaría aquí si venir a la escuela fuera mi decisión.' WHERE ru_question_number=108;
      ");
  }

  public function down()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
UPDATE question SET question_es = NULL WHERE question_es IS NOT NULL;
      ");
  }
}
