# -*- mode: ruby -*-
# vi: set ft=ruby :


Vagrant.configure(2) do |config|

  config.vm.box = "ubuntu/trusty64"
  config.vm.network "private_network", ip: "192.168.56.225"

  config.vm.provider "virtualbox" do |v|
                   v.customize ["modifyvm", :id, "--memory", "1024"]
                   v.customize ["modifyvm", :id, "--cpus", "2"]
                 end

  config.vm.hostname = "api.local.keinewaste.org"

  config.vm.synced_folder ".", "/vagrant", type: "nfs"

  config.vm.provision "shell", path: "puppet/modules/scripts/files/init.sh", args: ""


  config.vm.provision :shell do |shell|
    shell.inline = "mkdir -p /etc/puppet/modules;
    puppet module install puppetlabs-stdlib --force;
    puppet module install example42-apt --force;
    puppet module install luckyknight-hhvm --force;
    puppet module install example42/perl --force;
    "
  end

  config.vm.provision :puppet do |puppet|
      puppet.manifests_path = 'puppet/manifests'
      puppet.module_path = 'puppet/modules'
      puppet.manifest_file = 'init.pp'
  end

  config.vm.provision "shell", path: "puppet/modules/scripts/files/post.sh", args: ""

end