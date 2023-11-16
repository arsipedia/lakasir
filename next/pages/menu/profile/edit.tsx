import { NextPage } from "next";
import Layout from "../../../components/Ui/Layout";
import Image from "next/image";
import Button from "../../../components/Ui/Buttons/Button";
import Form from "../../../components/Ui/Fields/Form";
import Input from "../../../components/Ui/Fields/Input";
import { Select } from "../../../components/Ui/Fields/Select";

const EditProfile: NextPage = () => {
  return (
    <Layout
      title="Edit Profile"
      back
    >
      <div className="py-3">
        <Form
          className="space-y-8"
          initialValue={{
          }}
          onSubmit={() => console.log("ok")}
        >
          {() => (
            <>
              <div className="flex justify-between">
                <div className="w-28 h-28 bg-transparent border-[10px] border-lakasir-primary rounded-[20px] flex justify-center items-center cursor-pointer">
                  <Image
                    src={"/assets/icons/Image.svg"}
                    width={"50%"}
                    height={"50%"}
                  />
                </div>
                <Input
                  name={"name"}
                  type={"text"}
                  label={
                    <>
                      Name<span className="text-red-500">*</span>
                    </>
                  }
                />
              </div>
              <Input
                name={"email"}
                type={"text"}
                label={
                  <>
                    Email<span className="text-red-500">*</span>
                  </>
                }
              />
              <Input
                name={"phone"}
                type={"text"}
                label={
                  <>
                    Phone<span className="text-red-500">*</span>
                  </>
                }
              />
              <Input
                name={"address"}
                type={"textarea"}
                label={
                  <>
                    Address<span className="text-red-500">*</span>
                  </>
                }
              />
              <Select
                name={"Language"}
                label={
                  <>
                    Language<span className="text-red-500">*</span>
                  </>
                }
              />
              <Button className="w-full py-4">Save</Button>
            </>
          )}
        </Form>
      </div>
    </Layout>
  );
};

export default EditProfile;