pipeline {
  agent {
    node {
      label 'node1'
    }

  }
  stages {
    stage('prepare') {
      steps {
        echo 'prepare'
        build 'docker build'
      }
    }

  }
}