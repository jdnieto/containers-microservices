# Exercise 01 - Installing *podman*
----------
## Microsoft Windows (Windows Subsystem for Linux 2.0 - WSL2)
You can find the official guide [here](https://www.redhat.com/sysadmin/podman-windows-wsl2)

## macOS
```bash
brew install podman
```

## Linux
1. **Arch & Manjaro**
    ```bash
    sudo pacman -S podman
    ```
2. **CentOS**
    ```bash
    # CentOS 7
    sudo curl -L -o /etc/yum.repos.d/devel:kubic:libcontainers:stable.repo https://download.opensuse.org/repositories/devel:/kubic:/libcontainers:/stable/CentOS_7/devel:kubic:libcontainers:stable.repo
    sudo yum -y install podman

    # CentOS 8
    sudo dnf -y module disable container-tools
    sudo dnf -y install 'dnf-command(copr)'
    sudo dnf -y copr enable rhcontainerbot/container-selinux
    sudo curl -L -o /etc/yum.repos.d/devel:kubic:libcontainers:stable.repo https://download.opensuse.org/repositories/devel:/kubic:/libcontainers:/stable/CentOS_8/devel:kubic:libcontainers:stable.repo
    sudo dnf -y install podman

    # CentOS Stream
    sudo dnf -y module disable container-tools
    sudo dnf -y install 'dnf-command(copr)'
    sudo dnf -y copr enable rhcontainerbot/container-selinux
    sudo curl -L -o /etc/yum.repos.d/devel:kubic:libcontainers:stable.repo https://download.opensuse.org/repositories/devel:/kubic:/libcontainers:/stable/CentOS_8_Stream/devel:kubic:libcontainers:stable.repo
    sudo dnf -y install podman
    ```
3. **Fedora**
    ```bash
    sudo dnf -y install podman
    ```
4. **Debian**
    ```bash
    # Debian Unstable/Sid
    echo 'deb https://download.opensuse.org/repositories/devel:/kubic:/libcontainers:/stable/Debian_Unstable/ /' > /etc/apt/sources.list.d/devel:kubic:libcontainers:stable.list
    curl -L https://download.opensuse.org/repositories/devel:/kubic:/libcontainers:/stable/Debian_Unstable/Release.key | sudo apt-key add -

    # Debian Testing
    echo 'deb https://download.opensuse.org/repositories/devel:/kubic:/libcontainers:/stable/Debian_Testing/ /' > /etc/apt/sources.list.d/devel:kubic:libcontainers:stable.list
    curl -L https://download.opensuse.org/repositories/devel:/kubic:/libcontainers:/stable/Debian_Testing/Release.key | sudo apt-key add -

    # Debian 10
    echo 'deb https://download.opensuse.org/repositories/devel:/kubic:/libcontainers:/stable/Debian_10/ /' > /etc/apt/sources.list.d/devel:kubic:libcontainers:stable.list
    curl -L https://download.opensuse.org/repositories/devel:/kubic:/libcontainers:/stable/Debian_10/Release.key | sudo apt-key add -

    sudo apt-get update -qq
    sudo apt-get -qq -y install podman
    ```
5. **Ubuntu**
   ```bash
   . /etc/os-release
    echo "deb https://download.opensuse.org/repositories/devel:/kubic:/libcontainers:/stable/xUbuntu_${VERSION_ID}/ /" | sudo tee /etc/apt/sources.list.d/devel:kubic:libcontainers:stable.list
    curl -L https://download.opensuse.org/repositories/devel:/kubic:/libcontainers:/stable/xUbuntu_${VERSION_ID}/Release.key | sudo apt-key add -
    sudo apt-get update
    sudo apt-get -y upgrade 
    sudo apt-get -y install podman
   ```
