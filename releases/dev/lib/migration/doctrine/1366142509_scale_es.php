<?php

class ScaleEs extends Doctrine_Migration_Base
{
  public function up()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
UPDATE scale_value SET description_es='Blanco' WHERE description='White';
UPDATE scale_value SET description_es='Afroamericano/Negro' WHERE description='African American/Black';
UPDATE scale_value SET description_es='Indio americano' WHERE description='American Indian';
UPDATE scale_value SET description_es='Asiático/de las islas del Pacífico' WHERE description='Asian/Pacific Islander';
UPDATE scale_value SET description_es='Hispano y/o latino' WHERE description='Hispanic and/or Latino';
UPDATE scale_value SET description_es='Otro/más de uno' WHERE description='Other/More than One';
UPDATE scale_value SET description_es='Masculino' WHERE description='Male';
UPDATE scale_value SET description_es='Femenino' WHERE description='Female';
UPDATE scale_value SET description_es='Estoy totalmente en desacuerdo' WHERE description='Strongly Disagree';
UPDATE scale_value SET description_es='Estoy en desacuerdo' WHERE description='Disagree';
UPDATE scale_value SET description_es='Neutral/indeciso' WHERE description='Unsure / Undecided';
UPDATE scale_value SET description_es='Estoy de acuerdo' WHERE description='Agree';
UPDATE scale_value SET description_es='Estoy totalmente de acuerdo' WHERE description='Strongly Agree';
UPDATE scale_value SET description_es='No tengo nada de confianza' WHERE description='Not Confident at All';
UPDATE scale_value SET description_es='Normalmente no tengo confianza' WHERE description='Mostly Not Confident';
UPDATE scale_value SET description_es='Tengo confianza regular' WHERE description='Somewhat Confident';
UPDATE scale_value SET description_es='Normalmente tengo confianza' WHERE description='Mostly Confident';
UPDATE scale_value SET description_es='Tengo muchísima confianza' WHERE description='Extremely Confident';
UPDATE scale_value SET description_es='Casi nunca' WHERE description='Almost Never';
UPDATE scale_value SET description_es='No muy seguido' WHERE description='Not Very Often';
UPDATE scale_value SET description_es='Medio seguido' WHERE description='Somewhat Often';
UPDATE scale_value SET description_es='Muy seguido' WHERE description='Very Often';
UPDATE scale_value SET description_es='Casi siempre' WHERE description='Almost Always';
      ");
  }

  public function down()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
UPDATE scale_value SET description_es = NULL WHERE description_es IS NOT NULL;
      ");
  }
}
