<?php

namespace App\Form;

use App\Entity\Note;
use App\Entity\Matiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note', null, ['label' => 'formulaire.labels.nom_note'])

            ->add('matiere', EntityType::class, [
                'class' => Matiere::class,
                'label' => 'formulaire.labels.choix_matiere',
                'choice_label' =>function ($matiere) {
                return $matiere->getNom(). " - coeff " . $matiere->getCoefficient();}
            ])
            ->add('Envoyer', SubmitType::class,['label' => 'formulaire.action.envoie']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
