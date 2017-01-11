Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/xenial64"
  config.vm.network "private_network", ip: "100.100.100.100"
  config.vm.synced_folder ".", "/vagrant", mount_options: ['dmode=777','fmode=777']
  config.vm.synced_folder ".", "/var/www/html/app", mount_options: ['dmode=777','fmode=777']
  if Vagrant.has_plugin?("vagrant-vbguest") then
    config.vbguest.auto_update = true
  end

  config.vm.provision "shell", path: "init.sh"
end
