<?php

namespace Hubsine\SkeletonBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

/**
 * UniqueEntryValidator checks if there is just one entry in database.
 * 
 *
 * @Annotation
 * 
 * @author Hubsine <contact@hubsine.com>
 */
class UniqueEntryValidator extends ConstraintValidator
{
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }
    
    public function validate($entity, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueEntry) {
            throw new UnexpectedTypeException($constraint, UniqueEntryValidator::class);
        }

        if (null === $entity) {
            return;
        }
        
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $entity || '' === $entity) {
            return;
        }
        
        if ($constraint->em) 
        {
            $em = $this->registry->getManager($constraint->em);

            if (!$em) 
            {
                throw new ConstraintDefinitionException(sprintf('Object manager "%s" does not exist.', $constraint->em));
            }
            
        } else 
        {
            $em = $this->registry->getManagerForClass(\get_class($entity));

            if (!$em) 
            {
                throw new ConstraintDefinitionException(sprintf('Unable to find the object manager associated with an entity of class "%s".', \get_class($entity)));
            }
        }

        $class = $em->getClassMetadata(\get_class($entity));
        /* @var $class \Doctrine\Common\Persistence\Mapping\ClassMetadata */

        if (null !== $constraint->entityClass) 
        {
            /* Retrieve repository from given entity name.
             * We ensure the retrieved repository can handle the entity
             * by checking the entity is the same, or subclass of the supported entity.
             */
            $repository = $em->getRepository($constraint->entityClass);
            $supportedClass = $repository->getClassName();

            if (!$entity instanceof $supportedClass) 
            {
                throw new ConstraintDefinitionException(sprintf('The "%s" entity repository does not support the "%s" entity. The entity should be an instance of or extend "%s".', $constraint->entityClass, $class->getName(), $supportedClass));
            }
        } else 
        {
            $repository = $em->getRepository(\get_class($entity));
        }

        $criteria = [];
        $countEntryResult = $repository->{$constraint->repositoryMethod}($criteria);

        if( $countEntryResult === 0 )
        {
            return;
        }
        
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ entry_class }}', get_class($entity))
            ->addViolation();
    }
}
