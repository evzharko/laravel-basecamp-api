<?php

namespace Belvedere\Basecamp\Sections;

use Belvedere\Basecamp\Models\Person;

class People extends AbstractSection
{
    /**
     * Get people.
     *
     * @param  string  $nextPage
     * @return \Illuminate\Support\Collection
     */
    public function index($nextPage = null)
    {
        $url = $nextPage ?: 'people.json';

        $people = $this->client->get($url);

        return $this->indexResponse($people, Person::class);
    }

    /**
     * Get people on a project.
     *
     * @param  int     $bucket
     * @param  string  $nextPage
     * @return \Illuminate\Support\Collection
     */
    public function inProject($bucket, $nextPage = null)
    {
        $url = $nextPage ?: sprintf('projects/%d/people.json', $bucket);

        $people = $this->client->get($url);

        return $this->indexResponse($people, Person::class);
    }

    /**
     * Update an access to a project.
     *
     * @param  int     $bucket
     * @param  array   $data
     * @return \Illuminate\Support\Collection
     */
    public function updateAccessToProject($bucket, $data)
    {
        $access = $this->client->put(
            sprintf('projects/%d/people/users.json', $bucket),
            [
                'json' => $data,
            ]
        );

        return $this->response($access);
    }

    /**
     * Get pingable people.
     *
     * @param  string  $nextPage
     * @return \Illuminate\Support\Collection
     */
    public function pingable($nextPage = null)
    {
        $url = $nextPage ?: 'circles/people.json';

        $people = $this->client->get($url);

        return $this->indexResponse($people, Person::class);
    }

    /**
     * Get a person.
     *
     * @param  int  $id
     * @return \Illuminate\Support\Collection
     */
    public function show($id)
    {
        $person = $this->client->get(sprintf('people/%d.json', $id));

        return new Person($this->response($person));
    }

    /**
     * Get my profile.
     *
     * @return \Illuminate\Support\Collection
     */
    public function profile()
    {
        $profile = $this->client->get('my/profile.json');

        return new Person($this->response($profile));
    }
}
