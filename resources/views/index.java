public static void wellcome() {
    public class Person{
        private String name;
        private int age;

        public Person(String name , int age){
            this.name =name;
            this.age = age;
        }
        public String getName(){
            return name;
        }
        public int getAge(){
            return age;
        }
    }
    Person person =new Person("mahmoud ",30);

    System.out.println("name :"+person.getName());
    System.out.println("age :"+person.getAge());
}
