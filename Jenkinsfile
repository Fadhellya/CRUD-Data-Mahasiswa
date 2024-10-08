pipeline {
    agent any
    environment {
        IMAGE_NAME = 'fadhellya/sample:latest'
        CONTAINER_NAME = 'sample_container'
        DB_CONTAINER_NAME = 'dbsample'
        DB_VOLUME_NAME = 'dbsample_volume'
        DB_NETWORK_NAME = 'sample_network'
        PHPMYADMIN_CONTAINER_NAME = 'phpmyadmin_sample'
        DOCKER_USERNAME = credentials('usernamedocker')
        DOCKER_PASSWORD = credentials('passworddocker')
        REMOTE_HOST = '10.20.10.245'
        REMOTE_USER = 'master'
        REMOTE_PASSWORD = credentials('remotePassword')  // Menambahkan kredensial untuk password server
        DB_PASS = credentials('dbpassword')
        DB_NAME = credentials('dbname')
        DB_USER = 'student'
        DB_HOST = "${DB_CONTAINER_NAME}"
        DB_PORT_CONTAINER = '3306'
        PHPMYADMIN_PORT_HOST = '8080'
        PHPMYADMIN_PORT_CONTAINER = '80'
        APP_PORT_HOST = '80'
        APP_PORT_CONTAINER = '80'
    }

    options {
        timeout(time: 30, unit: 'MINUTES')
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    sh '''
                    docker build -t ${IMAGE_NAME} .
                    '''
                }
            }
        }

        stage('Push Docker Image') {
            steps {
                script {
                    sh '''
                    echo "${DOCKER_PASSWORD}" | docker login -u ${DOCKER_USERNAME} --password-stdin
                    docker push ${IMAGE_NAME}
                    '''
                }
            }
        }

        stage('Deploy Docker Container on Remote Server') {
            steps {
                script {
                    echo "Deploying Docker Container on Remote Server"
                    echo "Remote Host: ${REMOTE_HOST}"

                    // Menggunakan SSH dengan password untuk login ke server remote
                    sh '''
                    sshpass -p "${REMOTE_PASSWORD}" ssh -o StrictHostKeyChecking=no ${REMOTE_USER}@${REMOTE_HOST} <<EOF
echo "${DOCKER_PASSWORD}" | sudo docker login -u ${DOCKER_USERNAME} --password-stdin
sudo docker stop ${CONTAINER_NAME} || true
sudo docker rm ${CONTAINER_NAME} || true
sudo docker stop ${PHPMYADMIN_CONTAINER_NAME} || true
sudo docker rm ${PHPMYADMIN_CONTAINER_NAME} || true
sudo docker stop ${DB_CONTAINER_NAME} || true
sudo docker rm ${DB_CONTAINER_NAME} || true
sudo docker volume create ${DB_VOLUME_NAME} || true
sudo docker network create ${DB_NETWORK_NAME} || true
sudo docker pull ${IMAGE_NAME}
sudo docker run -d -p ${DB_PORT_CONTAINER} --name ${DB_CONTAINER_NAME} --restart unless-stopped -e MARIADB_ROOT_PASSWORD=${DB_PASS} -e MARIADB_USER=${DB_USER} -e MARIADB_PASSWORD=${DB_PASS} -e MARIADB_DATABASE=${DB_NAME} --network ${DB_NETWORK_NAME} -v ${DB_VOLUME_NAME}:/var/lib/mysql docker.io/mariadb
sudo docker run -d -p ${PHPMYADMIN_PORT_HOST}:${PHPMYADMIN_PORT_CONTAINER} -e PMA_HOST=${DB_CONTAINER_NAME} --name ${PHPMYADMIN_CONTAINER_NAME} --restart unless-stopped --network ${DB_NETWORK_NAME} docker.io/phpmyadmin
sudo docker run -d --name ${CONTAINER_NAME} --network ${DB_NETWORK_NAME} -p ${APP_PORT_HOST}:${APP_PORT_CONTAINER} --restart unless-stopped -e DB_HOST=${DB_HOST} -e DB_USER=${DB_USER} -e DB_PASS=${DB_PASS} -e DB_NAME=${DB_NAME} ${IMAGE_NAME}
EOF
                    '''
                }
            }
        }
    }

    post {
        always {
            cleanWs()
        }
        success {
            echo 'Deployment succeeded!'
        }
        failure {
            echo 'Deployment failed!'
        }
    }
}
