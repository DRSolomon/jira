<?php

namespace Technodelight\Jira\Helper;

use Technodelight\GitShell\ApiInterface as Api;
use Technodelight\GitShell\Branch;
use Technodelight\Jira\Domain\Issue;

class GitBranchCollector
{
    /**
     * @var Api
     */
    private $git;
    /**
     * @var GitBranchnameGenerator
     */
    private $generator;

    public function __construct(Api $git, GitBranchnameGenerator $generator)
    {
        $this->git = $git;
        $this->generator = $generator;
    }

    public function forIssue(Issue $issue)
    {
        $generatedName = $this->generator->fromIssue($issue);
        return array_map(
            function(Branch $branch) {
                return sprintf('%s (%s)', $branch->name(), $branch->isRemote() ? 'remote' : 'local');
            },
            array_merge(
                $this->git->branches($issue->ticketNumber()),
                $this->git->branches($generatedName)
            )
        );
    }

    public function forIssueWithAutoGenerated(Issue $issue)
    {
        if ($branches = $this->forIssue($issue)) {
            return $branches;
        }

        return [
            $this->generator->fromIssue($issue) . ' (generated)',
        ];
    }
}
