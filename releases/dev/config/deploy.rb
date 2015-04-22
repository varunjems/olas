set :application, "olas"
set :domain,      "olas.wevad.com"
set :deploy_to,   "/home/dev/#{application}"

set :user,       "dev"
set :use_sudo,   false

#set :repository,  "#{domain}:/var/repos/#{application}.git"
set :repository,  "ssh://git@bitbucket.org/roverwolf/#{application}.git"
set :scm,         :git
#set :scm,         :none
#set :scm,         :subversion
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, `subversion` or `none`

ssh_options[:forward_agent] = true
set :branch, "develop"

# Can possibly use the following to deploy via copy
#set :repository, "."
#set :scm, :none
#set :deploy_via, :copy
#set :copy_cache, "/tmp/deploy-olas"
#set :copy_compression, :gzip

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Rails migrations will run

set  :keep_releases,  3
after "deploy", "deploy:cleanup"

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL


desc "Setup composer"
after "deploy:share_childs" do
  run "cd #{release_path} && ( [ ! -x composer.phar ] && (curl -sS https://getcomposer.org/installer | php) ) && ./composer.phar self-update && ./composer.phar install", :roles => :app
end

