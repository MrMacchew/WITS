### Github+1 Workflow

Github Flow is a lightweight branched based workflow for Git. Github Flow only contains one main branch `master` and feature branches are created from it. However, Github+1 Flow model uses two major branches `master` and `develop`. Hence, the feature branches are created from `develop` branch. And the master is a stable state of the program. All changes and experiments should be made on `feature` branches so that code is reviewed by other people in the team before it is merged into `develop`.  Your feature branches should be verbosely descriptive so that other people in the team can clearly see what is being worked on.

### Working with Branches

A new branch is created from the develop branch `git checkout -b feature/{descriptive-name}` to make newer changes to the code.

If you are working on a `feature`, the branch should have the name `feature/{descriptive-name}`.

If you are working on a `issue`. the branch should have the name `issue/{descriptive-name}`.

#### Commits

Commits should be made after logical changes, additionally, make sure that logical units of code.

`git add -A` or `git add -A hello.py`

followed by

`git commit -m "Added hello.py` or `git commit` and an interactive terminal will allow you to write your commit message.


These commits messages are useful because it allows the modification of code to be tracked. Furthermore, each commit is a seperate unit of change. Hence, if a bug is found, an easy rollback is possible.

> By writing clear commits messages, you can make it easier for other people to follow the changes
> in your code and provide better feedback.

### Pull Requests

Pull requests let you tell others about changes you've pushed to a repository on GitHub. Once a pull request is opened, you can discuss and review the potential changes with collaborators and add follow-up commits before the changes are merged into the repository.

After you have created your feature branch, and made commits to it. It is now time to create a pull request on Github. The `develop` branch currently and the develop branch you checkouted out your current working branch may (probably will) be different because other people in the team may have made changes or sent pull request to the project.  Hence, make sure the current branch you are working on is always upto date with the `develop`.

`git checkout develop && git pull && git checkout - && git rebase develop`

or simply

`git pull --rebase origin develop`

> Again, make sure you title the Pull Requests title verbosely so that team members
> can clear understand what is being worked on.

Git is really flexible about merging conflicts, however, you'll probably see some merge errors when you are working in the same area (lines) as the develop branch, which is evolving constantly. The error message will verbosely state the merge conflicts. Henceforth, you should merge these changes into your current working branch. Do this often so that, there isn't a large numeber of merge errors at once.

When there is a merge conflict, `git rebase --continue` will allow you to integrate newer changes from the develop branch into your current working branch. After these changes are made you will need to add these changes into git with `git add file.name`. The commit is handled by the rebasing process therefore `git commit` is not required.

Consider reading, [How to Write the Perfect Pull Request](https://github.com/blog/1943-how-to-write-the-perfect-pull-request)

#### Accepting Pull Requests

Each pull request should only have one commit, if you have multiple commits, espcially if they are meaning less, i.e. missed an comma or added file. These commits do not provide any additional value to the code therefore rebase these meaningless commits into one commit using rebase. Squash these commits.

Make sure you are on your current working branch.

`git log` Will help you see the commits you have made.
`git rebase -i HEAD~4` Selects the last four commits you made. This snippet only starts the process of rebasing. You do not have to squash all your commits. These can be picked on the followup screen.

The available rebase options are;

```
# p, pick = use commit
# r, reword = use commit, but edit the commit message
# e, edit = use commit, but stop for amending
# s, squash = use commit, but meld into previous commit
# f, fixup = like "squash", but discard this commit's log message
# x, exec = run command (the rest of the line) using shell
# d, drop = remove commit
```

The following snippet shows commit `6340aaa` `ebfd367` `30e0ccb` is being squashed into `01d1124` commit.

```
pick 01d1124 Adding functional print module
squash 6340aaa Missed a simple function
squash ebfd367 Jekyll has become self-aware.
squash 30e0ccb Changed the line from a to b.

```

After you have squashed multiple commits into one, because of change in git history.A force push, `git push -f` is required to send these changes to upstream (remote). Since you are working on your own branch, this is allowed.

The reviewer or the team lead will assign a team member to merge these changes into the develop branch. This is usually going to be the same person who sent the pull request.

> You can only squash newer commits to an older one. However, you can ammend the old commit message by putting a `reword` instead of `pick` while rebasing. Also, if you are squshing commits using id's, choose the following commit id of the commit you want to rebase.

##### [WIP] Pull Requests

You are welcome to open pull requests even though you have not completed a feature or a issue so that team members can review your code from the very begining. No other team member will "touch" your `branch` unless you explicitly ask to do so. Make sure you label this clearly with a [WIP] tag in the beginning of the name so that team members can easily filter these pull requests unless you explitcly ask for help.

> Be careful while force pushing into shared branches. As this changes the history, make sure the collabrates know of this by commeting on the pull requests. A better way is to not rebase till the feature is fully ready to merge. The latter is preferred.

### Merging Current Branch into Develop

After the pull request has been approved, you can merge these changes directly from Github or if there are merge conflicts, locally on your computer.

Naming convention for merge commit: Merge: feature/{branch} via Pull Request #{number}
Example, Merge: feature/database via Pull Request #1

Make sure that the pull request number is added on to the merge commit so that other team members can easily reference the changes and the comments for this merge.

On Github, make sure that you merge your changes with `create a merge commit` so that the history of your branch will be moved over to the develop branch.

On your local computer, you will follow these steps,

**Step 1**: From your project repository, bring in the changes and test.
```
git fetch origin

# do this step if you are assigned another branch that you have not made changes to
# otherwise this step should already be done when you pushed your branch upstream

git checkout -b feature/{branch} origin/feature/{branch}
git merge develop
```

**Step 2**: Merge the changes and update on GitHub.
```
git checkout develop
git merge --no-ff feature/{branch}
git push origin develop
```

Note: The `--no-ff` is important so that the history of your branch will be moved over to the develop branch.

> If your branch name is not meaningful, the Team Lead will ask you to rename your branch, as you do this, you will need to create a new pull request. Rename branch using `git branch -m feature/{new-name}`

### Stashing Commits

Often, when working on a project, you would want to switch branches when you want to work on something else for a bit or there is a issue you need to fix urgently. And you do no want to commit half done work because someone else is reviewing your code. The answer to this issue is `git stash`. Stash takes the current state of your working directory (the changes you made) and saves in a stack.

```
$ git stash
$
$ git stash list
stash@{0}: WIP on feature/changes: 043d356 added the controller
```

With this, you can switch branches and work on something different. After a while, when you come back to finish the feature with do `git stash apply` to reapply the changes you made to the working directory.

> If you have made multiple items on your stash, do git stash list to see which one you want to reapply.
> Then, reapply a particular stash using `git stash apply stash@{0}`
> Otherwise, since the stash is stored in a stack it pop outs the last inserted item.

### Reverting Commits

This usage of git reset is a simple way to undo changes that haven’t been shared with anyone else. It’s your go-to command when you’ve started working on a feature and find yourself thinking, “Oh crap, what am I doing? I should just start over.” - [via Atlassian](https://www.atlassian.com/git/tutorials/resetting-checking-out-and-reverting)

You can reset your commits using the `--hard` or the `--mixed flag`. The latter is default.

```
git reset --hard SHA_ID or HEAD~1
git reset --mixed SHA_ID or HEAD~1
git reset HEAD~1 # defaults to git reset --mixed
```

The `--hard` takes the commits and **modifies your directory** so that your code matches the commit exactly. All changes will be removed.

The `--mixed` flag takes the commits and unstages changes after this commit. You will still have the **changes in your working directory**.

Usually, use the latter, and you can stash your changes so that you still have access to the changes if you need them later. If you want to start over and want a clean directory use `--hard` reset.


### Tagging Commits

Git tags are used to indentify stable release. The use of schematic versioning for tags allows for version numbers and the way they change convey.

```
Given a version number MAJOR.MINOR.PATCH, increment the:

MAJOR version when you make incompatible API changes,
MINOR version when you add functionality in a backwards-compatible manner, and
PATCH version when you make backwards-compatible bug fixes.
Additional labels for pre-release and build metadata are available as extensions to the MAJOR.MINOR.PATCH format.

```
[Schematic Versioning](http://semver.org)

A simple `git tag [version]` will tag the commit you are currently on.
To remove the tag, `git tag -d [version]` will remove the tag.

You can also annotate and attach a message a tag so that it is descriptive.

`git tag -a -m "Release Tag Message 1.0" v1.0`

Don't forget you need to push your tags seperately with `git push --tags`

> The Team Lead is responsible for chronially tagging commits using Schematic Versioning. A team member seldom tags a commit.

### Blaming Others

Git blame searches the commit history and allows you to see who is the last person who modified the particular line of code.

You can do this simply with `git blame file.name`
Additionally, you can search specific line numbers with `git blame file.name -L 32,45`

If you want to go back and see how and who has changed the file use the following snippet.

```
git log -p -M --follow --stat -- file.name
```

If there are problems in the code, do a `git blame`, and create a issue on Github and mention the team member in the issue so that the person can get back to you before making changes.

### A few Git tips and tricks

1. Use aliases for git, this various git commands in a few keystrokes. Mine is attached [here](https://github.com/theshapguy/macos_provision/blob/b30e89694bfb24e7cfddb3e1e687445fcf46f307/files/dot/gitconfig). Copy this file into your home directory at `~/.gitconfig` to access this aliases.

2. Also consider using a bash prompt (PS1) that allows you to see which branch you are working on. My `bash_profile` [here](https://github.com/theshapguy/macos_provision/blob/b30e89694bfb24e7cfddb3e1e687445fcf46f307/files/dot/bash_profile) which includes the PS1. Copy this file or the PS1 section (probably just the PS1 section along with `parse_git_branch` function) into your `~/.bash_profile`. After this run `source ~/.bash_profile` to update these aliases.

3. I know using Github GUI is easy however, it only harnesses a mere potential of Git. Therefore start loving using git via command-line and leave the GUI behind.

4. Make sure to set your name in git so that when you push, we exactly know who the team member is
    ```
    git config --global user.name "Shap Guy"
    git config --global user.email "shapathneupane@weber.edu"
    ```

    Drop the `--global` flag if you only want to change your email for this specific repository. Make sure you use your Weber email so that your personal email is not attached to commits.

5. `#TODO about git commit template ~/.gittemplate`

6. `git push -f` is **only allowed** on branches *you* are working on. Changing the history, in any way, of the repo will be frowned upon.

7. It is better to use `git add -A` rather than `git add .` because the first one automatically tracks file deletions in the working directory.

> Git's policy is commit often, rebase later, push once.

### Additional Resources

[Become a Git Guru](https://www.atlassian.com/git/tutorials)

[Most commonly used Git Tips and Tricks](https://github.com/git-tips/tips)

[Git Workflow Tips](http://nuclearsquid.com/writings/git-tricks-tips-workflows/)

[GitLab Tips and Tricks](https://about.gitlab.com/2016/12/08/git-tips-and-tricks/)
