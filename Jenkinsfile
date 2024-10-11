pipeline {
    agent any
    environment {
        IMAGE_NAME = 'fadhellya/sample:latest'
        DOCKER_USERNAME = credentials('usernamedocker')
        DOCKER_PASSWORD = credentials('passworddocker')
        KUBE_CONFIG = credentials('KUBE_KONFIG')  // Add Kubernetes kubeconfig file to Jenkins credentials
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

        stage('Deploy to Kubernetes') {
            steps {
                script {
                    echo "Deploying to Kubernetes Cluster"
                    
                    // Use kubectl to apply Kubernetes deployment manifests
                    sh '''
                    export KUBECONFIG=$KUBE_CONFIG
                    kubectl set image deployment/sample-deployment sample-container=${IMAGE_NAME} --record
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
            echo 'Deployment to Kubernetes succeeded!'
        }
        failure {
            echo 'Deployment to Kubernetes failed!'
        }
    }
}
