### Contributing Guide


#### How to contribute?

WIITS is willing to take pull requests from anyone. One person cannot be simply doing everything for the project. Contributing to this project is kept as simple as possible, especially when the ADMINS are doing merges via pull requests.

#### Getting Started

1. Make sure you have a Github Account
2. Clone the repository on to your local computer
        `git clone git@github.com:WSUWITTS/WITS.git`


#### Making Changes

1. On your local computer, checkout the issue or feature you will be working on.
    `git checkout -b feautre/database`
    `git checkout -b issue/migrations`

2. Push the branch `git push --set-upstream origin feature/database`
3. Make commits of logical units.
4. Push the branch to the remote server (Github - Origin)

5. Create a Pull Request on Github after feature has been completed.
   Make sure the Pull Request have tests included.

6. When the ADMINS have concurred with your branch,
    Rebase your commits with HEAD or SHA
    ``git rebase -i HEAD~2``


### Revert Policy

Only ADMINS have rights to roll back commits on the `master` and `develop` branch. These two branches are protrected, hence, the history cannot be changed. If the rollback ever takes place, ADMINS will notify everyone via email.

> Consider reading Git [schematics](https://github.com/WSUWITTS/WITS/blob/3b11435f5f8d7278eca0b9df11c000d107ff3db4/SCHEMATIC.md)

### Addional Resources

[Git Simple Guide](http://rogerdudler.github.io/git-guide/)

[Github Pull Request](https://help.github.com/articles/creating-a-pull-request/)

[General Github Documentation](https://help.github.com)
