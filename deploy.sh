
set -e

echo "Deploying application..."

eval `ssh-agent -s`
ssh-add resize

# Pull from git
git pull origin development