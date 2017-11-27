import graphene

class Pessoa(graphene.ObjectType):
    id = graphene.ID()
    nome = graphene.String()
    idade = graphene.Int()
    email = graphene.String()
    sexo = graphene.String()


class Query(graphene.ObjectType):

    pessoa = graphene.Field(Pessoa)

    def resolve_pessoa(self, info):
        return Pessoa(id=1, nome='Thiago', idade=22, email='thiago.gcosta13@gmail.com', sexo='masculino')
       
schema = graphene.Schema(query=Query)
query = '''
    query something{
      pessoa {
        id
        nome
        idade
        email
        sexo
      }
    }
'''


def test_query():
    result = schema.execute(query)
    assert not result.errors
    assert result.data == {
        'pessoa': {
            'id': '1',
            'nome': 'Thiago',
            'idade': 27,
            'email': 'thiago.gcosta13@gmail.com',
            'sexo': 'masculino'
        }
    }


if __name__ == '__main__':
    result = schema.execute(query)
    print(result.data['pessoa'])
