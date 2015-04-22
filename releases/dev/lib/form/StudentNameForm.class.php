<?php

/**
 * Student Name form
 *
 * @package    olas
 * @subpackage form
 * @author     David Ward <dward@wevad.com>
 * @version    SVN: $Id$
 */
class StudentNameForm extends BaseForm
{
    protected $hasError = false;
    protected $canSkip = false;

	public function setup()
    {
		$this->setWidgets(array(
            'first_name' => new sfWidgetFormInputText(
                array(
                    'label'=>'Please enter your First Name.'
                ),
                array(
                    'maxlength' => '28',
                )
            ),

            'last_name'  => new sfWidgetFormInputText(
                array(
                    'label'=>'Please enter your Last Name.'
                ),
                array(
                    'maxlength' => '28',
                )
            ),

            'skip_name' => new sfWidgetFormInputHidden(),
		));

		$this->setValidators(array(
            'first_name' => new sfValidatorCallback(
                array(
                    'callback' => array($this, 'checkCharacters'),
                    'required' => false,
                ),
                array(
                    'required' => 'You must enter a First and Last Name before continuing.',
                )
            ),
            'last_name' => new sfValidatorCallback(
                array(
                    'callback' => array($this, 'checkCharacters'),
                    'required' => false,
                ),
                array(
                    'required' => 'You must enter a First and Last Name before continuing.',
                )
            ),
            'skip_name' => new sfValidatorPass(),
            /*
            'first_name' => new sfValidatorRegex(array(
                'pattern' => '/^([a-zA-Z-]){2,28}$/',
                'required' => true,
            ), array(
                'required' => 'You must enter a First and Last Name before continuing.',
                'invalid' => 'First Name and Last Name must not contain special characters (such as @ or &) or numbers. Please enter letters only.',
            )),
            'last_name' => new sfValidatorRegex(array(
                'pattern' => '/^([a-zA-Z-]){2,28}$/',
                'required' => true,
            ), array(
                'required' => 'You must enter a First and Last Name before continuing.',
                'invalid' => 'First Name and Last Name must not contain special characters (such as @ or &) or numbers. Please enter letters only.',
            )),
             */
		));

        $this->validatorSchema->setPostValidator(
            new sfValidatorAnd(array(
                new sfValidatorCallback(array('callback' => array($this, 'checkEmpty'))),
                new sfValidatorCallback(array('callback' => array($this, 'checkNext'))),
            ))
        );

		$this->widgetSchema->setNameFormat('student_name[%s]');

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	}

    public function checkCharacters($validator, $value) {
        if (!strlen($value)) {
			throw new sfValidatorError($validator, 'You must enter a First and Last Name before continuing.');
        }

        $check = Accents::remove($value);
        if (
            (!preg_match('/^[a-zA-Z\.-][a-zA-Z\. -]{0,26}[a-zA-Z\.-]$/', $check))
            || ($check != trim($check)) // Do not allow leading/ending spaces
           ){
           $this->hasError = true;
           throw new sfValidatorError($validator, 'Please enter letters only. Each name must contain 2-28 characters.<br />Names must not contain special characters (such as @ or &) or numbers.');
        }

        return $value;
    }

    public function checkEmpty($validator, $values)
    {
        if (!$this->hasError && ($values['skip_name'] != 'yes') && (!strlen($values['first_name']) || !strlen($values['last_name']))) {
            throw new sfValidatorError($validator, 'Please enter your first and last name or click Next to continue.');
        }

        return $values;
    }

    public function checkNext($validator, $values)
    {
        if (!$this->hasError && (!strlen($values['first_name']) || !strlen($values['last_name']))) {
            $values['skip_name'] = 'yes';
            $this->canSkip = true;
        }

        return $values;
    }

    public function canSkip()
    {
        return $this->canSkip;
    }
}
