<?php

namespace Domain\Subscriber\ViewModels;

use Domain\Shared\ViewModels\ViewModel;
use Domain\Subscriber\DataTransferObjects\FormData;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Domain\Subscriber\DataTransferObjects\TagData;
use Domain\Subscriber\Models\Form;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class UpsertSubscriberViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Subscriber $subscriber = null
    ) {}

    public function subscriber(): ?SubscriberData
    {
        if (!$this->subscriber) {
            return null;
        }

        return SubscriberData::from(
            $this->subscriber->load('tags', 'form')
        );
    }

    /**
     * @return Collection<TagData>
     */
    public function tags(): Collection
    {
        return Tag::all()->map(fn (Tag $tag) => TagData::from($tag));
    }

    /**
     * @return Collection<FormData>
     */
    public function forms(): Collection
    {
        return Form::all()->map(fn (Form $form) => FormData::from($form));
    }

}