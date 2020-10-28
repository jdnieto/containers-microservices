from project import db

class Tareas(db.Model):
    id = db.Column(db.Integer, primary_key=True, autoincrement=True)
    tarea = db.Column(db.String(128), nullable=False)

    def __init__(self, tarea):
        self.tarea = tarea

    def to_json(self):
        return{
            'id': self.id,
            'tarea': self.tarea,
        }
