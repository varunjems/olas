<?php

class QuestionPageEs extends Doctrine_Migration_Base
{
  public function up()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
UPDATE question_page
   SET
title_es = 'LA IMPORTANCIA DE LA ESCUELA',
intro_es = '<p>En esta sección te preguntamos qué piensas sobre la <strong>importancia de la escuela y la universidad</strong>.</p><p>Recuerda que ésta no es una prueba y que no existen las respuestas correctas ni las incorrectas.</p><p>A continuación, selecciona la columna que mejor describe tu actitud u opinión actual.</p>',
instructions_es = 'Es importante que…'
 WHERE type = 'ru' AND page IN (3, 4);

UPDATE question_page
   SET title_es = 'LA IMPORTANCIA DE LA ESCUELA (continuación)'
 WHERE type = 'ru' AND page IN (4);



UPDATE question_page
   SET
title_es = 'LA CONFIANZA',
intro_es = '<p>En esta sección te preguntamos sobre cuánta <strong>confianza</strong> tienes al realizar una variedad de actividades relacionadas con el hecho de ser estudiante en tu escuela.</p><p>Recuerda que ésta no es una prueba y que no existen las respuestas correctas ni las incorrectas.</p><p>A continuación, selecciona la columna que mejor describe tu actitud u opinión actual.</p>',
instructions_es = 'Selecciona por favor cuánta confianza tienes en poder hacer las cosas siguientes con éxito…'
 WHERE type = 'ru' AND page IN (5, 6, 7);

UPDATE question_page
   SET title_es = 'LA CONFIANZA (continuación)'
 WHERE type = 'ru' AND page IN (6, 7);



UPDATE question_page
   SET
title_es = 'LAS RELACIONES PERSONALES',
intro_es = '<p>En esta sección te preguntamos acerca de tus <strong>relaciones</strong> con tus familiares, maestros y amigos.</p><p>Recuerda que ésta no es una prueba y que no existen las respuestas correctas ni las incorrectas.</p><p>A continuación, selecciona la columna que mejor describe tu actitud u opinión actual.</p>',
instructions_es = 'Selecciona por favor qué tan de acuerdo estás con cada punto:'
 WHERE type = 'ru' AND page IN (8, 9);

UPDATE question_page
   SET title_es = 'LAS RELACIONES PERSONALES (continuación)'
 WHERE type = 'ru' AND page IN (9);



UPDATE question_page
   SET
title_es = 'EL ESTRÉS',
intro_es = '<p>En esta sección te preguntamos acerca del <strong>estrés</strong> en tu vida.</p><p>Recuerda que ésta no es una prueba y que no existen las respuestas correctas ni las incorrectas.</p><p>A continuación, selecciona la columna que mejor describe tu actitud u opinión actual.</p>',
instructions_es = 'Por favor selecciona qué tan seguido has tenido cada una de las siguientes experiencias en el ÚLTIMO MES:'
 WHERE type = 'ru' AND page IN (10, 11, 12);

UPDATE question_page
   SET title_es = 'EL ESTRÉS (continuación)'
 WHERE type = 'ru' AND page IN (11, 12);



UPDATE question_page
   SET
title_es = 'EL BIENESTAR',
intro_es = '<p>En esta sección te preguntamos sobre tu <strong>salud y bienestar</strong>.</p><p>Recuerda que ésta no es una prueba y que no existen las respuestas correctas ni las incorrectas.</p><p>A continuación, selecciona la columna que mejor describe tu actitud u opinión actual.</p>',
instructions_es = 'Por favor selecciona qué tan seguido has sentido cada una de las cosas siguientes durante la ÚLTIMA SEMANA:'
 WHERE type = 'ru' AND page IN (13, 14, 15);

UPDATE question_page
   SET title_es = 'EL BIENESTAR (continuación)'
 WHERE type = 'ru' AND page IN (14, 15);



UPDATE question_page
   SET
title_es = 'LA MOTIVACIÓN',
intro_es = '<p>En esta sección te preguntamos acerca de tu <strong>motivación</strong> para ir a la escuela. Todas las personas tenemos diferentes razones para ir a la escuela; en esta sección te preguntamos qué tanto estás en acuerdo o en desacuerdo con cada una de las razones de abajo</p><p>Recuerda que ésta no es una prueba y que no existen las respuestas correctas ni las incorrectas.</p><p>A continuación, selecciona la columna que mejor describe tu actitud u opinión actual.</p>',
instructions_es = 'Sigo viniendo a la escuela porque…'
 WHERE type = 'ru' AND page IN (16, 17);

UPDATE question_page
   SET title_es = 'LA MOTIVACIÓN (continuación)'
 WHERE type = 'ru' AND page IN (17);






UPDATE question_page
   SET
title_es = 'LA IMPORTANCIA DE LA ESCUELA',
intro_es = '<p>En esta sección te preguntamos qué piensas sobre la <strong>importancia de la escuela y la universidad</strong>.</p><p>Recuerda que ésta no es una prueba y que no existen las respuestas correctas ni las incorrectas.</p><p>A continuación, selecciona la columna que mejor describe tu actitud u opinión actual.</p>',
instructions_es = 'Es importante que…'
 WHERE type = 'mo' AND page IN (3, 4);

UPDATE question_page
   SET title_es = 'LA IMPORTANCIA DE LA ESCUELA (continuación)'
 WHERE type = 'mo' AND page IN (4);



UPDATE question_page
   SET
title_es = 'LA CONFIANZA',
intro_es = '<p>En esta sección te preguntamos sobre cuánta <strong>confianza</strong> tienes al realizar una variedad de actividades relacionadas con el hecho de ser estudiante en tu escuela.</p><p>Recuerda que ésta no es una prueba y que no existen las respuestas correctas ni las incorrectas.</p><p>A continuación, selecciona la columna que mejor describe tu actitud u opinión actual.</p>',
instructions_es = 'Selecciona por favor cuánta confianza tienes en poder hacer las cosas siguientes con éxito…'
 WHERE type = 'mo' AND page IN (5, 6, 7);

UPDATE question_page
   SET title_es = 'LA CONFIANZA (continuación)'
 WHERE type = 'mo' AND page IN (6, 7);



UPDATE question_page
   SET
title_es = 'LAS RELACIONES PERSONALES',
intro_es = '<p>En esta sección te preguntamos acerca de tus <strong>relaciones</strong> con tus familiares, maestros y amigos.</p><p>Recuerda que ésta no es una prueba y que no existen las respuestas correctas ni las incorrectas.</p><p>A continuación, selecciona la columna que mejor describe tu actitud u opinión actual.</p>',
instructions_es = 'Selecciona por favor qué tan de acuerdo estás con cada punto:'
 WHERE type = 'mo' AND page IN (8, 9);

UPDATE question_page
   SET title_es = 'LAS RELACIONES PERSONALES (continuación)'
 WHERE type = 'mo' AND page IN (9);



UPDATE question_page
   SET
title_es = 'EL ESTRÉS',
intro_es = '<p>En esta sección te preguntamos acerca del <strong>estrés</strong> en tu vida.</p><p>Recuerda que ésta no es una prueba y que no existen las respuestas correctas ni las incorrectas.</p><p>A continuación, selecciona la columna que mejor describe tu actitud u opinión actual.</p>',
instructions_es = 'Por favor selecciona qué tan seguido has tenido cada una de las siguientes experiencias en el ÚLTIMO MES:'
 WHERE type = 'mo' AND page IN (10, 11, 12);

UPDATE question_page
   SET title_es = 'EL ESTRÉS (continuación)'
 WHERE type = 'mo' AND page IN (11, 12);



UPDATE question_page
   SET
title_es = 'EL BIENESTAR',
intro_es = '<p>En esta sección te preguntamos sobre tu <strong>salud y bienestar</strong>.</p><p>Recuerda que ésta no es una prueba y que no existen las respuestas correctas ni las incorrectas.</p><p>A continuación, selecciona la columna que mejor describe tu actitud u opinión actual.</p>',
instructions_es = 'Por favor selecciona qué tan seguido has sentido cada una de las cosas siguientes durante la ÚLTIMA SEMANA:'
 WHERE type = 'mo' AND page IN (13, 14, 15);

UPDATE question_page
   SET title_es = 'EL BIENESTAR (continuación)'
 WHERE type = 'mo' AND page IN (14, 15);



UPDATE question_page
   SET
title_es = 'LA MOTIVACIÓN',
intro_es = '<p>En esta sección te preguntamos acerca de tu <strong>motivación</strong> para ir a la escuela. Todas las personas tenemos diferentes razones para ir a la escuela; en esta sección te preguntamos qué tanto estás en acuerdo o en desacuerdo con cada una de las razones de abajo</p><p>Recuerda que ésta no es una prueba y que no existen las respuestas correctas ni las incorrectas.</p><p>A continuación, selecciona la columna que mejor describe tu actitud u opinión actual.</p>',
instructions_es = 'Sigo viniendo a la escuela porque…'
 WHERE type = 'mo' AND page IN (16, 17);

UPDATE question_page
   SET title_es = 'LA MOTIVACIÓN (continuación)'
 WHERE type = 'mo' AND page IN (17);
      ");
  }

  public function down()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
UPDATE question_page SET title_es = NULL, intro_es = NULL, instructions_es = NULL;
      ");
  }
}
